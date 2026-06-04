<?php

$content = file_get_contents('resources/views/admin/wawancara_bod/index.blade.php');

// Let's strip comments
$content = preg_replace('/\{\{--.*?--\}\}/s', '', $content);

// Let's extract the content inside the @foreach($pesertas as $akun) ... @endforeach loop
if (preg_match('/@foreach\s*\(\$pesertas\s*as\s*\$akun\)(.*?)@endforeach/s', $content, $matches)) {
    $loopContent = $matches[1];
    
    // Let's tokenise HTML tags in the loop content
    preg_match_all('/<div[^>]*>|<\/div>/i', $loopContent, $tags);
    
    $depth = 0;
    $lineNumber = 1;
    $lines = explode("\n", $loopContent);
    
    echo "Tokens in loop:\n";
    foreach ($lines as $i => $line) {
        $lineNum = $i + 1;
        // Find tags in this line
        preg_match_all('/<div[^>]*>|<\/div>/i', $line, $lineTags);
        foreach ($lineTags[0] as $tag) {
            if (str_starts_with($tag, '</')) {
                $depth--;
                echo "Line $lineNum: Close tag (depth: $depth) -> " . htmlspecialchars($tag) . "\n";
            } else {
                echo "Line $lineNum: Open tag (depth: $depth) -> " . htmlspecialchars($tag) . "\n";
                $depth++;
            }
        }
    }
    echo "Final depth: $depth\n";
} else {
    echo "Could not find foreach loop.\n";
}
