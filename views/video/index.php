<link href="https://vjs.zencdn.net/7.0.3/video-js.css" rel="stylesheet">
<style>

    .box { position: relative; float: left; width: 300px}
    .content { padding: 5px; border: 0px solid #ccc; border-radius: 2px; }
    #container { background: #fff none repeat scroll 0 0;  margin: 0 auto; width: 1800px; }
    .vjs-paused .vjs-big-play-button,
    .vjs-paused.vjs-has-started .vjs-big-play-button {
        display: block;
    }
    .video-js .vjs-big-play-button{
        font-size: 2.5em;
        line-height: 2.3em;
        height: 2.5em;
        width: 2.5em;
        -webkit-border-radius: 2.5em;
        -moz-border-radius: 2.5em;
        border-radius: 2.5em;
        background-color: #73859f;
        background-color: rgba(115,133,159,.5);
        border-width: 0.1em;
        margin-top: -1.25em;
        margin-left: -1.75em;
    }
    /* 中间的播放箭头 */
    .vjs-big-play-button .vjs-icon-placeholder {
        font-size: 1.63em;
    }
    /* 加载圆圈 */
    .vjs-loading-spinner {
        font-size: 2.5em;
        width: 2em;
        height: 2em;
        border-radius: 1em;
        margin-top: -1em;
        margin-left: -1.5em;
    }
</style>


<div id="container">
<script src="https://vjs.zencdn.net/7.0.3/video.js"></script>
</div>
<script type="text/javascript">
var MAX_IDX = 0;
var BEF_IDX = 0;
window.onload = function () {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:18686/video/video?index=" + MAX_IDX, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var resultObj = JSON.parse(xhr.responseText);
            resultObj = resultObj.result;
            var videoInfos = resultObj;
            waterFall(videoInfos);
        }
    }
    xhr.send(null);
    BEF_IDX = MAX_IDX;
}
window.onscroll = function () {
    if(isScrollBottom()){
        if(BEF_IDX == MAX_IDX)
            return;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://localhost:18686/video/video?index=" + MAX_IDX, true);
        // console.log("get data index:" + MAX_IDX);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                var resultObj = JSON.parse(xhr.responseText);
                resultObj = resultObj.result;
                var videoInfos = resultObj;
                waterFall(videoInfos);
            }
        }
        xhr.send(null);
        BEF_IDX = MAX_IDX;
    }
}

function waterFall(data){
    var cparent = document.getElementById("container");
    for(var i=0;i<data.length;i++){
        if (data[i].id < MAX_IDX || MAX_IDX == 0) 
            MAX_IDX = data[i].id;
        if(!data[i].width) continue;
        var ratio = 300 / data[i].width;
        var height = ratio * data[i].height;
        var box = document.createElement("div");
        box.className = "box";
        box.style.height = height + 'px';
        cparent.appendChild(box);
        var content = document.createElement("div");
        content.className = "content";
        box.appendChild(content);
        var video = document.createElement('video');
        video.setAttribute("src", data[i].url);
        video.setAttribute("controls", "controls");
        video.setAttribute("width", "100%");
        video.setAttribute("id", data[i].id);
        video.setAttribute("class", "video-js vjs-big-play-centered");
        video.onclick = function(event){
            if(event.currentTarget.paused) {
                pauseAll();
                event.currentTarget.play();
            } else {
                event.currentTarget.pause();
            }
        }
        content.appendChild(video);
    }
    reLocation();
}

function pauseAll(){
    var videoList = document.getElementsByTagName("video");
    // console.log(videoList);
    for(var i=0;i<videoList.length;i++){
        if(!videoList[i].paused)
            videoList[i].pause();
    }
}

function isScrollBottom(){
    var cparent = document.getElementById("container");
    var ccontent = getChildElement(cparent,"box");
    //最后一张图片出现一半时的页面高度
    var lastContentHeight = ccontent[ccontent.length - 1].offsetTop + Math.floor(ccontent[ccontent.length - 1].offsetHeight/2);
    // 当前页面的高度
    var pageHeight = document.documentElement.clientHeight||document.body.clientHeight;
    // 鼠标滚动的高度
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    //是否允许滚动
    return (lastContentHeight < (pageHeight + scrollTop))?true:false;
}
function reLocation() {
    var cparent = document.getElementById("container");
    //获取所有类名为box的元素
    var ccontent = getChildElement(cparent,"box");
    //第一张图片的宽度
    var imgWidth = ccontent[0].offsetWidth;
    //第一列图片数量
    var numLine = Math.floor(document.documentElement.clientWidth/imgWidth);
    //设置父容器的宽度
    cparent.style.cssText = "width:"+ imgWidth * numLine  + "px";
    //获取每一张图片的高度
    var  boxHeightArr = [];
    for(var i=0;i<ccontent.length;i++){
        if(i<numLine){
            //把第一行元素的高度添加到数组中去
            boxHeightArr[i] = ccontent[i].offsetHeight + 35;
            ccontent[i].style.top = "40px";
        }else {
            //获取第一行图片高度最低的图片,然后把第二行第一种图片放在其下面，以此类推
            var minHeight = Math.min.apply(null,boxHeightArr);
            //获取最低高度图片的Index
            var minIndex = getMinHeightIndex(boxHeightArr,minHeight);
            ccontent[i].style.position = "absolute";
            ccontent[i].style.top = minHeight+"px";
            ccontent[i].style.width = "300px";
            ccontent[i].style.left = ccontent[minIndex].offsetLeft+"px";
            //重新计算高度
            boxHeightArr[minIndex] += ccontent[i].offsetHeight;
        }
    }
}
function getMinHeightIndex(boxHeightArr, minHeight) {
    for(var i in boxHeightArr){
        if(boxHeightArr[i] === minHeight){
            return i;
        }
    }
}
function getChildElement(parent,className) {
    var contentArr = [];
    var allcontent = parent.getElementsByTagName("*");
    for(var i=0;i<allcontent.length;i++){
        if(allcontent[i].className === className){
            contentArr.push(allcontent[i]);
        }
    }
    return contentArr;
}
</script>
<!-- <script src="assets/js/index.js"></script> -->