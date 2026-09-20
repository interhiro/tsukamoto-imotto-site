<?php

	$setting=unserialize(@file_get_contents(DATA_DIR.'/setting/overnotes.dat'));
	ini_set('mbstring.http_input', 'pass');
	parse_str($_SERVER['QUERY_STRING'],$_GET);
	$keyword=isset($_GET['k'])?trim($_GET['k']):'';
	$category=isset($_GET['c'])?trim($_GET['c']):'';
	$page=isset($_GET['p'])?trim($_GET['p']):'';
	$base_title = !empty($setting['title'])? $setting['title'] : 'OverNotes';

?><?php echo "<?xml version='1.0' encoding='UTF-8' ?>\n" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>検索結果｜<?php echo $base_title; ?></title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link  href="./_sys/css/sample.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc=" crossorigin="anonymous"></script>

</head>
<body id="inner" class="sub">
  <div id="wrapper">
		<div id="header">
				<h1>検索結果｜<?php echo $base_title; ?></h1>
				<p class="logo"><a href="./"><?php echo $base_title; ?></a></p>
		</div>
		
		<div id="gnav">
				<ul class="clearfix">
					<li><a href="./">Home</a></li>
					<li><a href="./search.php">検索</a></li>
				</ul>
		</div>
		
		<div id="main">

      <div class="section">
        <form method="get" action="">
          <span class="section_ttl">カテゴリ：</span><select name="c">
            <option value="">全てのカテゴリ</option>
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
              <option value="<?php echo $id; ?>"<?php echo $selected; ?>><?php echo $category_name; ?></option>
            <?php
	}
?>
          </select>
          　　<span class="section_ttl">キーワード：</span><input type="text" name="k" value="<?php echo @$_GET['k']; ?>">
          <input type="submit" value="検索" />
        </form>
        
        <?php $limitNum=10 ?>
      <div class="section">
        <?php
	$contribute_index=contribute_search(
		@$_GET['c']
		,''
		,@$_GET['k']
		,''
		,''
		,''
	);
	$max_record_count=count($contribute_index);

	$current_page=(@$_GET['p'])?(@$_GET['p']):1;
	$contribute_index=array_slice($contribute_index,($current_page-1)*$limitNum,$limitNum);
	$record_count=count($contribute_index)

?>
        <h3>検索結果：<?php echo $max_record_count; ?>件</h3>
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
            <?php
	foreach($field as $field_index=>$field_data){
		$ONFieldName=$field_data['name'];
		if(@strlen(@$contribute['data'][$field_id][$field_index]) || @is_array(@$contribute['data'][$field_id][$field_index])){
			$ONFieldValue=make_value(
				$field_data['name']
				,@$contribute['data'][$field_id][$field_index]
				,$field_data['type']
				,$id
				,$field_id
				,$field_index
			);
			if($field_data['type']=='image'){
				$ONFieldSrc=ROOT_URI.'/_data/contribute/images/'.@$contribute['data'][$field_id][$field_index];
			}else{
				$ONFieldSrc='';
			}
		}else{
			$ONFieldValue='';
			$ONFieldSrc='';
		}

?>
              <?php echo $ONFieldName; ?>:<?php echo htmlspecialchars($ONFieldValue); ?><br />
            <?php
	}
?>
            <hr />
        <?php
		foreach($field as $field_index=>$field_data){
			unset(${$field_data['code'].'_Name'});
			unset(${$field_data['code'].'_Value'});
			unset(${$field_data['code'].'_Src'});
		}
	}
?>
        
        </div>

        <div class="pager">
        <?php
	$page_count=(int)ceil($max_record_count/(float)$limitNum);
?>
        <?php
	if($max_record_count >= $limitNum){
?>
        <p class="center">
        <?php
	if($current_page <= 1){
?>
        <<
        <?php
	}else{
?>
        <a href="?c=<?php echo urlencode(@$_GET['c']); ?>&k=<?php echo urlencode(@$_GET['k']); ?>&p=<?php echo $current_page-1; ?>"><<</a>
        </ONElse>
        <?php
	}
?>
         
         <?php
	$page_old=@$page;
	for($page=1;$page<=$page_count;$page++){
?>
         <?php
	if($current_page == $page){
?>
        <?php echo $page; ?>
        <?php
	}else{
?>
        <a href="?c=<?php echo urlencode(@$_GET['c']); ?>&k=<?php echo urlencode(@$_GET['k']); ?>&p=<?php echo $page; ?>"><?php echo $page; ?></a>
        </ONElse>
        <?php
	}
?>
        <?php
	}
$page=$page_old;
?>
         
        <?php
	if($current_page<$max_record_count){
?>
        <a href="?c=<?php echo urlencode(@$_GET['c']); ?>&k=<?php echo urlencode(@$_GET['k']); ?>&p=<?php echo $current_page+1; ?>">>></a>
        <a href="">→</a>

        <?php
	}else{
?>
        >>
        </ONEse>
        <?php
	}
?>
        </p>
        <?php
	}
?>
        
        </div>
      </div>


        
        <div id="onlist">
          <table>
          </table>
        </div>

			</div>
		</div>
	</div>
  <div id="footer">
    Copyright(c) 2012 FREESALE INC. All Right Reserved.
  </div>
</body>
</html>