<?php

	$setting=unserialize(@file_get_contents(DATA_DIR.'/setting/overnotes.dat'));
	ini_set('mbstring.http_input', 'pass');
	parse_str($_SERVER['QUERY_STRING'],$_GET);
	$keyword=isset($_GET['k'])?trim($_GET['k']):'';
	$category=isset($_GET['c'])?trim($_GET['c']):'';
	$page=isset($_GET['p'])?trim($_GET['p']):'';
	$base_title = !empty($setting['title'])? $setting['title'] : 'OverNotes';

?><!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NMZTJCWM');</script>
<!-- End Google Tag Manager -->
<?php
	$contribute=get_contribute($contribute_id);
		$title=$contribute['title'];
	$h1=$contribute['h1'];
	if(empty($h1)){
		$h1=$title;
	}
	$keyword=$contribute['keyword'];
	$description=$contribute['description'];
	$category_id=$contribute['category'];
	$category_data=unserialize(@file_get_contents(DATA_DIR.'/category/'.$category_id.'.dat'));
	$category_name=$category_data['name'];
	$category_text=@$category_data['text'];
	$category_url=$category_data['id'];
	$field_id=$contribute['field'];
	$id=$contribute['id'];
	$field=get_field($field_id);
	$date=$contribute['public_begin_datetime'];
	$url=$contribute['url'].'/';

	foreach($field as $field_index=>$field_data){
		${$field_data['code'].'_Name'}=$field_data['name'];
		${$field_data['code'].'_Value'}=make_value(
		$field_data['name']
				,@$contribute['data'][$field_id][$field_index]
			,$field_data['type']
			,$id
			,$field_id
			,$field_index
		);

		if($field_data['type']=='image'){
			${$field_data['code'].'_Src'}=ROOT_URI.'/_data/contribute/images/'.@$contribute['data'][$field_id][$field_index];
		}
		if($field_data['type']=='pdf'){
			${$field_data['code'].'_Src'}=ROOT_URI."/_data/contribute/pdfs/{$id}_{$field_index}/".@$contribute['data'][$field_id][$field_index];
		}
	}

?>
<?php
$current_category_id   = $category_id;
$current_category_name = $category_name;
?>
<?php
	$category_index=get_category_index();
	foreach($category_index as $rowid=>$id){
		$category_data=unserialize(@file_get_contents(DATA_DIR.'/category/'.$id.'.dat'));
		$category_url=$category_data['id'];
		$category_name=$category_data['name'];
		$category_text=@$category_data['text'];
		$category_id=$id;
		${'category'.$id.'_url'}=$category_data['id'];
		${'category'.$id.'_name'}=$category_data['name'];
		${'category'.$id.'_text'}=@$category_data['text'];
		$selected=(@$_GET['c']==$id?' selected="selected"':'');

?>
<?php if( $current_category_id==$category_id ) $current_category_url = $category_url; ?>
<?php
	}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, maximum-scale=5.0, initial-scale=1.0, user-scalable=yes">
<title><?php echo $title; ?>｜相模原市・厚木市のアイモット</title>
<?php
	if($keyword){
?>
<meta name="keywords" content="<?php echo $keyword; ?>">
<?php
	}else{
?>
<meta name="keywords" content="<?php echo $title; ?>,<?php echo $current_category_name; ?>,相模原市,厚木市,アイモット">
<?php
	}
?>
<?php
	if($description){
?>
<meta name="description" content="<?php echo $description; ?>">
<?php
	}else{
?>
<meta name="description" content="<?php echo $title; ?>相模原市・厚木市の不動産売却・相続相談はアイモットへ。">
<?php
	}
?>
<meta name="robots" content="max-image-preview:large">
<!-- META -->
<meta name="format-detection" content="telephone=no,date=no,address=no,email=no,url=no">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="mobile-web-app-capable" content="yes">

<!-- FAVICON -->
<link rel="icon" href="../../favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" sizes="180x180" href="../../favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../favicon/favicon-16x16.png">
<link rel="manifest" crossorigin="use-credentials" href="../../favicon/site.webmanifest">

<!-- STYLESHEET -->
<link rel="stylesheet" media="all" href="../../css/base.css">
<link rel="stylesheet" media="all" href="../../css/fonts.css">
<link rel="stylesheet" media="all" href="../../css/styles.css">
<link rel="stylesheet" media="all" href="../../css/responsive.css">
<link rel="stylesheet" media="all" href="../../css/under.css">
<link rel="stylesheet" media="all" href="../../css/under_responsive.css">
<link rel="stylesheet" media="all" href="../../css/type1-mid.css">
<script src="../../js/jquery.js"></script>

<!-- OGP Social Share - Facebook -->
<meta property="og:type" content="article">
<meta property="og:locale" content="ja_JP">
<meta property="og:url" content="https://www.imotto.co.jp/news/<?php echo $url; ?>">
<meta property="og:title" content="<?php echo $title; ?>｜相模原市・厚木市のアイモット">
<meta property="og:site_name" content="不動産のアイモット">
<meta property="og:phone_number" content="0120-984-113">
<?php
	if($description){
?>
<meta property="og:description" content="<?php echo $description; ?>">
<?php
	}else{
?>
<meta property="og:description" content="<?php echo $title; ?>相模原市・厚木市の不動産売却・相続相談はアイモットへ。">
<?php
	}
?>
<meta property="og:image" content="https://www.imotto.co.jp/images/ogp.jpg">
<meta name="thumbnail" content="https://www.imotto.co.jp/images/thumbnail.jpg">
<link rel="canonical" href="https://www.imotto.co.jp/news/<?php echo $url; ?>">

<!-- JSON BREADCRUMBS -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "ホーム",
        "item": "https://www.imotto.co.jp/"
    },
    {
        "@type": "ListItem",
        "position": 2,
        "name": "<?php echo $base_title; ?>",
        "item": "https://www.imotto.co.jp/news/"
    },
    {
        "@type": "ListItem",
        "position": 3,
        "name": "<?php echo $current_category_name; ?>",
        "item": "https://www.imotto.co.jp/news/<?php echo $current_category_url; ?>/"
    },
    {
        "@type": "ListItem",
        "position": 4,
        "name": "<?php echo $title; ?>",
        "item": "https://www.imotto.co.jp/news/<?php echo $url; ?>"
    }]
}
</script>
</head>

<body id="ovn_detail" class="under ovn_page type1-mid">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NMZTJCWM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div id="wrapper">
        
        <header>
            <div class="h_box">
                <div class="inner h_inner">
                    <!-- Header Content -->
                    <div class="h_left">
                        <?php if ($h1 == $title) { ?>
                             <h1 id="logo"><a href="../../../"><img src="../../images/logo.png" alt="<?php echo $title; ?>" width="400" height="60"></a></h1>
                        <?php } else  { ?>
                            <h1 id="logo"><a href="../../../"><img src="../../images/logo.png" alt="<?php echo $h1; ?>" width="400" height="60"></a></h1>
                        <?php } ?>
                       
                         <!-- Nav Menu -->
                        <nav>
                                <ul class="nav_list">
                                    <li><a href="../../../">ホーム</a></li>
                                    <li class="parent">
                                        <span class="sub_btn">売却を成功に導くポイント</span>
                                        <div class="sub">
                                            <ul>
                                                <li><a href="../../sell/guide/">売却の基礎知識</a></li>
                                                <li><a href="../../sell/sell-check.html">診断チャート</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="parent">
                                        <span class="sub_btn">売却方法から選ぶ</span>
                                        <div class="sub">
                                            <ul>
                                                <li><a href="../../sell/high.html">高く売りたい</a></li>
                                                <li><a href="../../sell/guide.html">早く売りたい</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="parent">
                                        <span class="sub_btn">お悩みから選ぶ</span>
                                        <div class="sub">
                                            <ul>
                                                <li><a href="../../situation/inheritance.html">不動産を相続した</a></li>
                                                <li><a href="../../situation/property-management.html">空き家の管理・不動産の整理</a></li>
                                                <li><a href="../../situation/relocation.html">住み替え・自宅の売却</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="parent">
                                        <span class="sub_btn">物件種別</span>
                                        <div class="sub">
                                            <ul>
                                                <li><a href="../../property/home.html">戸建て・区分マンション</a></li>
                                                <li><a href="../../property/vacant.html">空き家・空き地・訳あり物件</a></li>
                                                <li><a href="../../property/building.html">一棟アパート・マンション</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="parent">
                                        <span class="sub_btn">サービス案内</span>
                                        <div class="sub">
                                            <ul>
                                                <li><a href="../../buy/my-home.html">理想の家探し<br>（マイホーム購入の希望者向け）</a></li>
                                                <li><a href="../../buy/income-property.html">収益用不動産<br>（投資用購入の希望者向け）</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="parent">
                                        <span class="sub_btn">会社について</span>
                                        <div class="sub">
                                            <ul>
                                                <li><a href="../../company/message.html">代表紹介</a></li>
                                                <li><a href="../../company/#company_ttl_01">会社概要</a></li>
                                                <li><a href="../../company/">選ばれる理由</a></li>
                                                <li><a href="../../company/marketing.html">アイモットの売却活動</a></li>
                                                <li><a href="../../news/cate_1/">新着情報</a></li>
                                                <li><a href="../../news/cate_2/">ブログ</a></li>
                                                <li><a href="../../news/cate_3/">お客様の声</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="../../contact/">お問い合わせ</a></li>
                                   
                                </ul>
                                <div class="contet_sp sp">
                                    <div class="btn_box">
                                        <p class="btn-index btn-index2"><a href="#"><span class="txt">LINEで相談</span></a></p>
                                    </div>
                                    <div class="group_cta_logo">
                                        <p class="logo_cta"><img src="../../images/logo_cta.jpg" loading="lazy"  width="460" height="181" alt="iMotto 不動産の売却・相続・購入はアイモットへ"></p>
                                    </div>
                                    <div class="box_gnavi">
                                        <p class="logo_ft"><a href="../../../"><img src="../../images/logo_ft.png" loading="lazy" width="238" height="82" alt="不動産のアイモット 相模原市・厚木市"></a></p>
                                        <p class="info-company">
                                            <span class="txt txt-ttl">横浜本社</span>
                                            <span class="txt txt-info">横浜市西区みなとみらい3-7-1<br><span class="txt-info2">オーシャンゲートみなとみらい10F</span></span>
                                        </p>
                                        <p class="info-address">
                                            <a href="tel:0368200848" class="sweetlink txt-tel txt">TEL／03-6820-0848</a>
                                            <span class="txt txt-info">営業時間／9:00〜21:00</span>
                                        </p>
                                    </div>
                                </div>
                        </nav>
                    </div>
                    <div class="h_right">
                       
                        <div class="h_contact pc">
                            
                            <p class="h_contact_tel">
                                <a class="tel sweetlink" href="tel:0120984113"><span class="txt-tel">0120-984-113</span></a>
                                <span class="time">受付時間 9:00-21:00</span>
                            </p>
                        </div>
                    </div>
                    <p class="header__tel sp"><a class="sweetlink" href="tel:0120984113"><span class="ic-tel"><img src="../../images/icon-tel.png" width="35" height="49" alt="TEL"></span></a></p>
                    <!-- Hamburger Menu -->
                    <div class="hamburger hamburger--3dxy">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </header>
        <!-- end #header-->
        <main>
            <!-- content start -->
            <div id="content">
                <div id="top_info">
                    <div class="inner">
                        <p class="sg-hero-badge">NEWS / 記事</p>
<h2><?php echo $current_category_name; ?></h2>
<p class="sg-hero-lead">相模原市・厚木市の不動産に関する情報をお届けします。</p>
<span class="sg-hero-watermark" aria-hidden="true">News</span>
                    </div>
                </div>
                <div id="topic_path">
                    <div class="inner clearfix">
                        <ul>
                            <li><a href="../../../">ホーム</a></li>
                            <li><a href="../"><?php echo $base_title; ?></a></li>
                            <li><a href="../<?php echo $current_category_url; ?>/"><?php echo $current_category_name; ?></a></li>
                            <li><?php echo $title; ?></li>
                        </ul>
                    </div>
                </div>

                <div class="inner clearfix">
                   
                   
                    <section class="clearfix toc_content">
                        <div class="frame01">
                        <p class="ttl"><span class="sm">このページの内容</span></p>
                        <div id="toc"></div>
                        </div>
                    </section>
                    

                    <?php
                        for ($i = 1; $i <= 10; $i++) {
                            $imgValue = ${"img" . $i . "_Value"};
                            $imgSrc = ${"img" . $i . "_Src"};
                            $textValue = ${"text" . $i . "_Value"};
                            $tag_h = ${"title" . $i . "_Value"};
                            $title = ${"title"};

                            if ($tag_h || $imgValue || $textValue) {
                                echo '<section class="clearfix ovn_content js-toc-content">';
                                if ($tag_h) {
                                    echo '<h3>'.$tag_h.'</h3>';
                                }
                                if ($imgValue) {
                                    echo '<p class="center"><img src="'. $imgSrc .'" alt="'.  $title .'"></p>';
                                }

                                if ($textValue) {
                                    echo '<div>'. $textValue .'</div>';
                                }
                                echo '</section>';
                            }
                        }
                    ?>    

					<!-- PAGINATION -->
					<section class="clearfix">
                        <?php $current_url = $url; ?>
                        <?php
	$contribute_index=contribute_search(
		$current_category_id
		,''
		,''
		,''
		,''
		,''
	);
	$max_record_count=count($contribute_index);

?>
                            <?php
	$local_index=0;
	foreach($contribute_index as $rowid=>$index){
		$contribute=unserialize(@file_get_contents(DATA_DIR.'/contribute/'.$index['id'].'.dat'));
		$title=$contribute['title'];
		$url=$contribute['url'].'/';
		$category_id=$index['category'];
		$category_data=unserialize(@file_get_contents(DATA_DIR.'/category/'.$category_id.'.dat'));
		$category_name=$category_data['name'];
		$category_text=@$category_data['text'];
		$field_id=$index['field'];
		$date=$index['public_begin_datetime'];
		$id=$index['id'];
		$field=get_field($field_id);

		foreach($field as $field_index=>$field_data){
			${$field_data['code'].'_Name'}=$field_data['name'];
			${$field_data['code'].'_Value'}=make_value(
		$field_data['name']
				,@$contribute['data'][$field_id][$field_index]
				,$field_data['type']
				,$id
				,$field_id
				,$field_index
			);
	
			if($field_data['type']=='image'){
				${$field_data['code'].'_Src'}=ROOT_URI.'/_data/contribute/images/'.@$contribute['data'][$field_id][$field_index];
			}

		}
		$local_index++;

?>
                                <?php $pages[] = $url; ?>
                            <?php
		foreach($field as $field_index=>$field_data){
			unset(${$field_data['code'].'_Name'});
			unset(${$field_data['code'].'_Value'});
			unset(${$field_data['code'].'_Src'});
		}
	}
?>
                        
                        <?php $current_page = array_search($current_url,$pages); ?>
                        <ul class="btn_list">
                            <?php if($prev = @$pages[$current_page+1]): ?>
                            <li class="is_prev btn h_over"><a href="../<?php echo $prev ?>">前の記事へ</a></li>
                            <?php endif; ?>
                            <li class="is_none btn h_over"><a href="../<?php echo $current_category_url; ?>/">一覧へ戻る</a></li>
                            <?php if($next = @$pages[$current_page-1]): ?>
                            <li class="is_next btn h_over"><a href="../<?php echo $next ?>">次の記事へ</a></li>
                            <?php endif ?>
                        </ul>
                    </section>
                </div>
            </div>
            <!-- content end -->
        </main>
        <!-- end #main-->

        <footer>
            <!-- FOOTER TOP -->
            <div class="cta">
                <div class="inner">
                    <p class="ttl">
                        <span class="ja ja_big tt-ja"><span class="c_white">神奈川県</span>・<span class="c_white">東京都</span>の<br class="sp">不動産売却は、<br><span class="txt">まずはご相談から</span></span>
                    </p>
                    <p class="desc_cta">一人で悩まず、まずは代表に直接お話しください</p>
                    <div class="info_cta">
                        <div class="ct_info_cta">
                            <p class="btn-cta"><a href="../../contact/"><span class="txt">売却査定 ／ 相続　<br class="sp440">かんたんお問い合わせ</span></a></p>
                            <div class="group_cta">
                                <div class="box box_tel">
                                    <p class="tel_cta">
                                        <a href="tel:0120984113" class="sweetlink"><span class="txt-tel">0120-984-113</span></a>
                                        <span class="time-cta">受付時間 9:00-21:00</span>
                                    </p>
                                </div>
                                <div class="box box_line">
                                    <p class="line_cta"><a href="#"><span class="txt-line">LINEで相談</span></a></p>
                                </div>
                            </div>
                            <div class="group_cta_logo">
                                <p class="logo_cta"><img src="../../images/logo_cta.jpg" loading="lazy" width="460" height="181" alt="iMotto 不動産の売却・相続・購入はアイモットへ"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box_map_ft">
                <div class="inner">
                    <div class="box_left">
                        <div class="box_map box_map1">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3249.8673864019215!2d139.6341204!3d35.4580774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188f63abb9884d%3A0xe330131b5025444!2zaSBNb3R0b-agquW8j-S8muekvg!5e0!3m2!1sja!2s!4v1786435029145!5m2!1sja!2s" width="600" height="450" style="border:0;" allowfullscreen="" title="i Motto株式会社（アイモット株式会社）" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        </div>
                        <div class="box_info_map">
                            <p class="img"><img src="../../images/map1.jpg" loading="lazy" width="460" height="357" alt="Motto株式会社（アイモット株式会社）"></p>
                            <div class="info_map info_map1">
                                <dl>
                                    <dt>所在地</dt>
                                    <dd>横浜市西区みなとみらい3-7-1<br>オーシャンゲートみなとみらい10F</dd>
                                </dl>
                                <dl>
                                    <dt>TEL</dt>
                                    <dd>0120-984-113 ／03-6820-0848</dd>
                                </dl>
                                <dl>
                                    <dt>営業時間</dt>
                                    <dd>9:00〜21:00</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="box_right">
                        <div class="box_map box_map2">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3239.6462880562117!2d139.7177552762592!3d35.71032092837476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188d1b142df047%3A0xe9a8bdc7de80083f!2z44CSMTY5LTAwNTEg5p2x5Lqs6YO95paw5a6_5Yy66KW_5pep56iy55Sw77yR5LiB55uu77yZ4oiS77yZIEhKIFBMQUNFIFcgVG9reW8gOTg0IDExMw!5e0!3m2!1sja!2sjp!4v1786435278540!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" title="東京営業部" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        </div>
                        <div class="box_info_map">
                            <p class="img"><img src="../../images/map2.jpg" loading="lazy" width="460" height="357" alt="東京営業部"></p>
                            <div class="info_map info_map2">
                                <dl>
                                    <dt>所在地</dt>
                                    <dd>新宿区西早稲田1-9-9</dd>
                                </dl>
                                <dl>
                                    <dt>TEL</dt>
                                    <dd>0120-984-113 </dd>
                                </dl>
                                <dl>
                                    <dt>営業時間</dt>
                                    <dd>9:00〜21:00</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box_ft_link">
                <div class="inner">
                    <div class="box_left">
                        <p class="logo_ft"><a href="../../../"><img src="../../images/logo_ft.png" loading="lazy" width="238" height="82" alt="不動産のアイモット 相模原市・厚木市"></a></p>
                        <p class="info-company">
                            <span class="txt txt-ttl">横浜本社</span>
                            <span class="txt txt-info">横浜市西区みなとみらい3-7-1<br><span class="txt-info2">オーシャンゲートみなとみらい10F</span></span>
                        </p>
                        <p class="info-address">
                            <a href="tel:0368200848" class="sweetlink txt-tel txt">TEL／03-6820-0848</a>
                            <span class="txt txt-info">営業時間／9:00〜21:00</span>
                        </p>
                    </div>
                    <div class="box_right">
                        <div class="ft_link pc">
                            <div class="inner">
                                <div class="box">
                                    <ul>
                                        <li class="big"><p><a href="../../../">ホーム</a></p></li>
                                    </ul>
                                    <ul>
                                        <li class="big"><p>売却を成功に導くポイント</p></li>
                                        <li><a href="../../sell/guide/">売却の基礎知識</a></li>
                                        <li><a href="../../sell/sell-check.html">診断チャート</a></li>
                                    </ul>
                                    <ul>
                                        <li class="big"><p>売却方法から選ぶ</p></li>
                                        <li><a href="../../sell/high.html">高く売りたい</a></li>
                                        <li><a href="../../sell/guide.html">早く売りたい</a></li>
                                    </ul>
                                </div>
                                <div class="box">
                                    <ul>
                                        <li class="big"><p>お悩みから選ぶ</p></li>
                                        <li><a href="../../situation/inheritance.html">不動産を相続した</a></li>
                                        <li><a href="../../situation/property-management.html">空き家の管理・不動産の整理</a></li>
                                        <li><a href="../../situation/relocation.html">住み替え・自宅の売却</a></li>
                                    </ul>
                                    <ul>
                                        <li class="big"><p>物件種別</p></li>
                                        <li><a href="../../property/home.html">戸建て・区分マンション</a></li>
                                        <li><a href="../../property/vacant.html">空き家・空き地・訳あり物件</a></li>
                                        <li><a href="../../property/building.html">一棟アパート・マンション</a></li>
                                    </ul>
                                    <ul>
                                        <li class="big"><p>サービス案内</p></li>
                                        <li><a href="../../buy/my-home.html">理想の家探し（マイホーム購入の希望者向け）</a></li>
                                        <li><a href="../../buy/income-property.html">収益用不動産（投資用購入の希望者向け）</a></li>
                                    </ul>
                                </div>
                                <div class="box">
                                    <ul>
                                        <li class="big"><p><a href="../../contact/">お問い合わせ</a></p></li>
                                    </ul>
                                    <ul>
                                        <li class="big"><p>会社について</p></li>
                                        <li><a href="../../company/message.html">代表紹介</a></li>
                                        <li><a href="../../company/#company_ttl_01">会社概要</a></li>
                                        <li><a href="../../company/">選ばれる理由</a></li>
                                        <li><a href="../../company/marketing.html">アイモットの売却活動</a></li>
                                        <li><a href="../../news/cate_1/">新着情報</a></li>
                                        <li><a href="../../news/cate_2/">ブログ</a></li>
                                        <li><a href="../../news/cate_3/">お客様の声</a></li>
                                    </ul>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <address>&copy; i Motto Co., Ltd. All Rights Reserved.</address>

            <!-- FUNCTION CONTACT SP -->
            <ul class="sp_contact sp">
                <li class="sp_contact_mail">
                    <a href="../../contact/">
                        <span class="txt txt1">売却査定 ／ 相談</span>
                        <span class="txt txt2">かんたんお問い合わせ</span>
                    </a>
                </li>
                <li class="sp_contact_tel">
                    <a class="sweetlink" href="tel:0120984113">
                    <span class="txt-tel">0120-984-113</span>
                    <span class="txt-time">受付時間 9:00-21:00</span>
                    </a>
                </li>
                <li class="sp_contact_line"><a href="#"><span class="ic_line"><img src="../../images/ic_line.png" loading="lazy" width="51" height="48" alt="LINE"></span></a></li>
            </ul>
        </footer>

        <div class="box_fixed_pc pc">
            <div class="btn_box">
                <p class="btn-index btn-index1"><a href="../../contact/"><span class="txt">無料査定・相談はこちら</span></a></p>
                <p class="btn-index btn-index2"><a href="#"><span class="txt">LINEで相談</span></a></p>
            </div>
        </div>
        <p class="to_top"><img src="../../images/btn_top.png" loading="lazy" width="80" height="80" alt="トップに戻る"></p>
        <!-- end footer -->
    </div>
    <script src="../../js/sweetlink.js"></script>
    <script src="../../js/common.js"></script>
    <script src="../_sys/js/user-table-of-contents.js" defer></script>
</body>

</html>