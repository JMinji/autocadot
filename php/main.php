<?
# 상단배너 처리
$chkdate = date("Y-m-d");
$qry = db_query("SELECT * FROM tbl_banner_tma where b_type='1' and b_usechk='Y' and b_sdate <= '$chkdate' and b_edate>='$chkdate' order by b_sortnum asc");
while($row = db_fetch($qry)){

    $b_uid  = $row['b_uid'];
    $b_color  = $row['b_color'];
    $bann_img = "/uploads/banner/".$row['b_img1'];
    $bann_img_m = "/uploads/banner/".$row['b_img2'];
    $bann_target = (($row[b_target] == "1") ? "" : "target='_blank'");
    $bannerhtml .="<li style='background-color:$b_color'><a href='/_bannerclick.html?buid=$b_uid' $bann_target><img class=\"autocadot_banner_web\" src=\"$bann_img\"><img class=\"autocadot_banner_mob\" src=\"$bann_img_m\"></a></li>";

}

# 키워드 처리
$qry = db_query("SELECT bt_tid,count(*) as cnt FROM tbl_boardtag_tma group by bt_tid order by 2 desc limit 15");
while($row = db_fetch($qry)){

    $bt_tid  = $row['bt_tid'];

    $cinfo = db_select("select * from tbl_tag_tma where t_uid='$bt_tid'");
    $tname = $cinfo['t_name'];
    $tuid  = $cinfo['t_uid'];
    $tagHtml .= "<li><a href='/tag/?n=$tname&t=$tuid'>$tname</a></li>\n";

}
# 추천컨텐츠
$qry = db_query("SELECT * FROM tbl_board_tma where b_usechk='Y' and b_type='1' order by b_uid desc limit 4");
while($row = db_fetch($qry)){

    $title = $row['b_title'];
    $desc  = $row['b_desc'];
    $origin = $row['b_origin'];
    $originlink = $row['b_originurl'];
    $odate  = $row['b_oregdate'];
    $likecnt = number_format($row['b_likecnt']);
    $b_uid  = $row['b_uid'];

    if($row['b_img1'])$b_img1  = "/uploads/data/".$row['b_img1'];

    $linkinfo    = "http://www.autocadot.co.kr/view.html?buid=".$b_uid;

    $facebookurl =  "http://www.facebook.com/sharer/sharer.php?u=".$linkinfo;
    $twitterurl  =  "https://twitter.com/intent/tweet?text=".urlencode($title)."&url=".$linkinfo;
    $naverblogurl = "http://blog.naver.com/openapi/share?url=".$linkinfo."&title=".urlencode($title);


    $bgimg = "";
    if($_COOKIE['autocadpost'.$b_uid] !="")$bgimg ="style=\"background-image: url('/asset/img/autocadot_like_icon_on.png');\"";


    $listhtml1 .="
    <li class=\"share_con share_hide\">
    	<a href='/_click.html?buid=$b_uid'><img src=\"/asset/img/thumbnail-blank.gif\" width=\"100%\" class=\"lazy\" data-original=\"$b_img1\"></a>
    	<div class=\"contop_area\">
    	  <h3 class=\"ellipsis_line2\"><a href='/_click.html?buid=$b_uid'>$title</a></h3>
    	  <p class=\"ellipsis_line3\">$desc</p>
    	</div>
    	<div class=\"conbot_area\">
    	  <div class=\"conbot_text_area\">
    		<span>$origin</span>
            <span>$odate</span>
    	  </div>
    	  <div class=\"conbot_btn_area\">
    		<div class=\"conbot_btn_like\">
    		  <a href=\"javascript:postlike($b_uid)\"><button type=\"button\" id=\"like1img_${b_uid}\" $bgimg>좋아요</button></a>
              <span id=\"like1txt_${b_uid}\">$likecnt</span>
            </div>
    		<div class=\"conbot_btn_share\">
              <a>
              <button type=\"button\">
    			공유하기
    		  </button>
              </a>
    		</div>
    	  </div>
    	  <!--  conbot_btn_area e -->
    	</div>
    	<!-- conbot_text_area e -->
    	<div class=\"autodesk_share_menu\">
    	  <div class=\"share_menu_area\">
    		<p>공유하기</p>
    		<div class=\"share_menu_inner\">
    			<a href=\"$facebookurl\" target='_blank'>페이스북으로 공유하기</a>
            	<a href=\"$twitterurl\" target='_blank'>트위터로 공유하기</a>
            	<a href=\"$naverblogurl\" target='_blank'>네이버 블로그로 공유하기</a>
    		</div>
    	  </div>
    	</div>
    </li>
    ";
}

$qry = db_query("SELECT * FROM tbl_board_tma where b_usechk='Y' and b_type='2' order by b_uid desc limit 4");
while($row = db_fetch($qry)){

    $title = $row['b_title'];
    $desc  = $row['b_desc'];
    $origin = $row['b_origin'];
    $odate  = $row['b_oregdate'];
    $likecnt = number_format($row['b_likecnt']);
    $b_uid  = $row['b_uid'];

    $b_img1  = "/uploads/data/".$row['b_img1'];

    $facebookurl =  "http://www.facebook.com/sharer/sharer.php?u=".$linkinfo;
    $twitterurl  =  "https://twitter.com/intent/tweet?text=".urlencode($title)."&url=".$linkinfo;
    $naverblogurl = "http://blog.naver.com/openapi/share?url=".$linkinfo."&title=".urlencode($title);

    $bgimg = "";
    if($_COOKIE['autocadpost'.$b_uid] !="")$bgimg ="style=\"background-image: url('/asset/img/autocadot_like_icon_on.png');\"";

    $listhtml2 .="
    <li class=\"share_con share_hide\">
    	<a href='/_click.html?buid=$b_uid'><img src=\"/asset/img/thumbnail-blank.gif\" width=\"100%\" class=\"lazy\" data-original=\"$b_img1\"></a>
    	<div class=\"contop_area\">
    	  <h3 class=\"ellipsis_line2\"><a href='/_click.html?buid=$b_uid'>$title</a></h3>
    	  <p class=\"ellipsis_line3\">$desc</p>
    	</div>
    	<div class=\"conbot_area\">
    	  <div class=\"conbot_text_area\">
    		<span>$origin</span>
            <span>$odate</span>
    	  </div>
    	  <div class=\"conbot_btn_area\">
    		<div class=\"conbot_btn_like\">
                <a href=\"javascript:postlike($b_uid)\"><button type=\"button\" id=\"like1img_${b_uid}\" $bgimg>좋아요</button></a>
                <span id=\"like1txt_${b_uid}\">$likecnt</span>
            </div>
    		<div class=\"conbot_btn_share\">
              <a>
              <button type=\"button\">
    			공유하기
    		  </button>
              </a>
    		</div>
    	  </div>
    	  <!--  conbot_btn_area e -->
    	</div>
    	<!-- conbot_text_area e -->
    	<div class=\"autodesk_share_menu\">
    	  <div class=\"share_menu_area\">
    		<p>공유하기</p>
    		<div class=\"share_menu_inner\">
    			<a href=\"$facebookurl\" target='_blank'>페이스북으로 공유하기</a>
            	<a href=\"$twitterurl\" target='_blank'>트위터로 공유하기</a>
            	<a href=\"$naverblogurl\" target='_blank'>네이버 블로그로 공유하기</a>
    		</div>
    	  </div>
    	</div>
    </li>
    ";

}

$qry = db_query("SELECT * FROM tbl_board_tma where b_usechk='Y' and b_type='3' order by b_uid desc limit 4");
while($row = db_fetch($qry)){

    $title = cutstr($row['b_title'],44);
    $desc  = cutstr($row['b_desc'],48);
    $origin = $row['b_origin'];
    $odate  = $row['b_oregdate'];
    $likecnt = number_format($row['b_likecnt']);
    $b_uid  = $row['b_uid'];
    $psdtype = $psdcateArr[$row['b_psdtype']];

    $b_img1  = "/uploads/data/".$row['b_img1'];


    $psdlist .="
        <li>
          <img src=\"/asset/img/library_default.gif\" class=\"lazy\" data-original=\"$b_img1\">
          <dl>
            <dt class=\"ellipsis_line2\">$title</dt>
            <dd class=\"ellipsis_line2\">$desc</dd>
          </dl>
          <a href=\"javascript:pdfdownload($b_uid);\"><span>다운로드</span></a>
        </li>
    ";
}

$pagecss = "<link rel=\"stylesheet\" href=\"/asset/css/flexslider.css\" media=\"screen\">";

$field = array("bannerhtml","tagHtml","listhtml1","listhtml2","psdlist");
$field_text =array($bannerhtml,$tagHtml,$listhtml1,$listhtml2,$psdlist);
$_mainpage  = $_printpage->mainpage($dirpath,$page_name,$field,$field_text);
?>
