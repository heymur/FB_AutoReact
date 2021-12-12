<?php
  $cookie = '';
  $content = auto('https://mbasic.facebook.com/home.php?sk=h_chr', $cookie);
  preg_match('#target" value="(.+?)"#is', $content, $id_user);
  $id_user = $id_user['1'];
  preg_match('#fb_dtsg" value="(.+?)"#is', $content, $fb_dtsg);
  $fb_dtsg = $fb_dtsg['1'];
  if (preg_match_all('#ft_ent_identifier=(.+?)&#is', $content, $story)) {
    $datapost = file_get_contents('idpost.log');
    for ($i=0; $i<count($story['1']); $i++) {
echo count($story['1']);
      $id_stt = $story['1'][$i];
      $comment = array('❤',);
      $cmt = $comment[rand(0, count($comment)-1)];
      if (strpos($datapost, $id_stt) == 0) {
        $reaction = auto('https://mbasic.facebook.com/reactions/picker/?ft_id=' . $id_stt . '&av=' . $id_user, $cookie);
        preg_match_all('#a href="(.+?)"#is', $reaction, $love);
        auto('https://mbasic.facebook.com' . $love['1'][rand(0, 5)], $cookie, 'fb_dtsg=' . $fb_dtsg . '&reaction_type=2');
        //auto('https://mbasic.facebook.com/a/comment.php?ft_ent_identifier=' . $id_stt . '&av=' . $id_user, $cookie, 'fb_dtsg=' . $fb_dtsg . '&comment_text=' . urlencode($cmt));
       //echo 'Done ' . $id_stt . ' comment ' . $cmt . ' <br>';
       echo 'Berhasil Menanggapi Status -> ' . $id_stt . ' <br>';
        $data = fopen('idpost.log', 'a');
        fwrite($data, $id_stt . "\n");
        fclose($data);
      }

    }

  }
  function auto($url, $cookie, $post = '') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    if ($post) curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
  }

?>
