<?php
//START============================================================================================
// Fetches 'safely' the copyright footer from head office
// Called by the code line below
// if(function_exists('fetchURLL')) fetchUrl('http://localhost/yourfile.php');
function checkUrl($uri) {
  $handle = curl_init();
  $options = array(
      CURLOPT_URL            => $uri,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER         => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_ENCODING       => "",
      CURLOPT_AUTOREFERER    => true,
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_TIMEOUT        => 5,
      CURLOPT_MAXREDIRS      => 10,
  );
  curl_setopt_array( $handle, $options );
  $response = curl_exec($handle);
  $hlength  = curl_getinfo($handle, CURLINFO_HEADER_SIZE);
  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
  $body     = substr($response, $hlength);
  curl_close($handle);
  // If HTTP response is not 200, throw exception
  if ($httpCode != 200) {
    throw new Exception($httpCode);
  }
  return $body;
}
function fetchUrl($uri) {
  try {
    $response = checkUrl($uri);
    echo $response;
  } catch (Exception $e) {
    echo '<!-- IMPORT ERROR: ' . $e->getMessage() . ' -->';
  }
}
//END==============================================================================================
?>
