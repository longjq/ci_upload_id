<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="<?php echo base_url('assets/webuploader-0.1.5/webuploader.css'); ?>">
    <script src="<?php echo base_url('assets/webuploader-0.1.5/jquery.1.8.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/webuploader-0.1.5/webuploader.js'); ?>"></script>
<style type="text/css">
	/*遮罩层*/
#mid{
  display:none;
  width:100%;
  height:100%;
  background:#000;
  position:absolute;
  top:0;
  left:0;
  z-index:10;
  opacity:0.4;						/*背景的透明度:(Firefox适用；）*/
  filter:alpha(opacity =40);			/*背景的透明度:(IE适用)；
}

</style>
</head>
<body>
<!-- 遮盖层 -->
<div id="mid"></div>

<div id="uploader" class="wu-example">
<!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
        <div class="btns">
            <div id="picker">选择文件</div>
            <button id="ctlBtn" class="btn btn-default">开始上传</button>
    </div>
</div>



<script>
var BASE_URL = '<?php echo base_url(); ?>';

var thumbnailWidth = 100;
var thumbnailHeight = 100;

var uploader = WebUploader.create({
	// 选完文件后，是否自动上传。
    auto: true,
	
    // swf文件路径
    swf: BASE_URL + 'assets/webuploader-0.1.5/Uploader.swf',

    // 文件接收服务端。
    server: BASE_URL+'index.php/welcome/file_func',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false,
    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'jpg,jpeg',
        mimeTypes: 'image/*'
    }
});

// 当有文件被添加进队列的时候,生成缩略图
uploader.on( 'fileQueued', function( file ) {
$list = $('#thelist');
//  $('#thelist').append( '<div id="' + file.id + '" class="item">' +
//      '<h4 class="info">' + file.name + '</h4>' +
//      '<p class="state">等待上传...</p>' +
//  '</div>' );

//$('#thelist').append('');

var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<img>' +
                '<div class="info">' + file.name + '</div>' +
            '</div>'
            ),
        $img = $li.find('img');


    // $list为容器jQuery实例
    $list.append( $li );

    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
    }, thumbnailWidth, thumbnailHeight );



});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
	
	//创建遮盖层
	$('#mid').show();
	
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file ) {
    $( '#'+file.id ).addClass('upload-state-done');
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
    
    $('#mid').hide();
});

$('#ctlBtn').click(function(){
    //var file_counts = uploader.getFiles();
    uploader.upload();
	
});
</script>











</body>
</html>