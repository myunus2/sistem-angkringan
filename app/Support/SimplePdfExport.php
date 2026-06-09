<?php

namespace App\Support;

use Symfony\Component\HttpFoundation\StreamedResponse;

class SimplePdfExport
{
    public static function download(string $filename, string $title, array $lines): StreamedResponse
    {
        $pdf = static::render($title, $lines);

        return response()->streamDownload(
            static function () use ($pdf): void {
                echo $pdf;
            },
            $filename,
            [
                'Content-Type' => 'application/pdf',
            ],
        );
    }

    public static function render(string $title, array $lines): string
    {
        $allLines = array_values(array_filter([
            $title,
            'Dicetak: ' . now()->format('d-m-Y H:i:s'),
            '',
            ...$lines,
        ], static fn (?string $line): bool => $line !== null));

        $pages = array_chunk($allLines, 42);

        $objects = [];
        $objects[1] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

        $pageObjectIds = [];
        $nextObjectId = 3;

        foreach ($pages as $pageLines) {
            $stream = static::buildPageStream($pageLines);
            $streamObjectId = $nextObjectId++;
            $pageObjectId = $nextObjectId++;

            $objects[$streamObjectId] = "<< /Length " . strlen($stream) . " >>\nstream\n{$stream}\nendstream";
            $objects[$pageObjectId] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 1 0 R >> >> /Contents {$streamObjectId} 0 R >>";

            $pageObjectIds[] = $pageObjectId;
        }

        $kids = implode(' ', array_map(static fn (int $id): string => "{$id} 0 R", $pageObjectIds));
        $objects[2] = "<< /Type /Pages /Kids [{$kids}] /Count " . count($pageObjectIds) . ' >>';

        $catalogObjectId = $nextObjectId;
        $objects[$catalogObjectId] = '<< /Type /Catalog /Pages 2 0 R >>';

        ksort($objects);

        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [0 => 0];

        foreach ($objects as $id => $content) {
            $offsets[$id] = strlen($pdf);
            $pdf .= "{$id} 0 obj\n{$content}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n";
        $pdf .= '0 ' . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($id = 1; $id <= count($objects); $id++) {
            $offset = $offsets[$id] ?? 0;
            $pdf .= str_pad((string) $offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }

        $pdf .= "trailer\n";
        $pdf .= "<< /Size " . (count($objects) + 1) . " /Root {$catalogObjectId} 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    protected static function buildPageStream(array $lines): string
    {
        $stream = "BT\n/F1 12 Tf\n";
        $y = 800;

        foreach ($lines as $index => $line) {
            $fontSize = $index === 0 ? 14 : 11;
            $safeLine = static::escapeText(static::normalizeText($line));
            $stream .= "/F1 {$fontSize} Tf\n1 0 0 1 40 {$y} Tm ({$safeLine}) Tj\n";
            $y -= 18;
        }

        $stream .= "ET";

        return $stream;
    }

    protected static function normalizeText(string $text): string
    {
        $text = preg_replace('/\s+/', ' ', trim($text)) ?? '';
        $text = mb_strimwidth($text, 0, 105, '...');

        return iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text) ?: $text;
    }

    protected static function escapeText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\(', '\)'],
            $text,
        );
    }
}
