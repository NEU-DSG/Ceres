<?php



$oldRenderArray = var_export($renderArray, true);
//echo "<h3>old</h3><pre>";
//var_export($renderArray);
//echo "</pre>";

$newRenderArray = shortVarExport($renderArray, true);


//echo "<h3>new</h3><pre>";
echo $newRenderArray;
//echo "</pre>";


// Thanks https://gist.github.com/Bogdaan/ffa287f77568fcbb4cffa0082e954022
function shortVarExport($expression, $return=FALSE) {
    $export = var_export($expression, TRUE);
    $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
    $array = preg_split("/\r\n|\n|\r/", $export);
    $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
    $export = join(PHP_EOL, array_filter(["["] + $array));
    if ((bool)$return) {
        return $export; 
    } else {
        echo $export;
    }
    
}
