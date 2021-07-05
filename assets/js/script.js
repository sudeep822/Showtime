$(document).scroll(function(){    /* nav bar background color change*/
    var isScrolled=$(this).scrollTop()> $(".topBar").height();  //if top of the page is greater than top element ->true
    $(".topBar").toggleClass("scrolled", isScrolled);
})



function volumeToggle(button)
{
    var muted =$(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    $(button).find("i").toggleClass("fas fa-volume-mute");  /* toggleClass to chnge volume button */
    $(button).find("i").toggleClass("fas fa-volume-up");
}

function previewEnded(){
    $(".previewVideo").toggle();   /*toggling from video to image*/
    $(".previewImage").toggle();
}

function goBack()           /* to go back from curr page*/
{
    window.history.back();
}


function startHideTimer()  /* hiding back arrow*/
{
    var timeout = null;

    $(document).on("mousemove",function(){

        clearTimeout(timeout);
        $(".watchNav").fadeIn();    /*hide after 2 seconds*/

        timeout= setTimeout(function (){
            $(".watchNav").fadeOut();
        }, 2000)                       /* for 2 seconds */
    })
}


function initVideo(videoId, username)
{
    startHideTimer();
    setStartTime(videoId, username);
    updateProgressTimer(videoId, username);
}

function updateProgressTimer(videoId,username)
{   
    addDuration(videoId,username);

    var timer;

    $("video").on("playing", function(event){
        window.clearInterval(timer);
        timer= window.setInterval(function(){
            
            updateProgress(videoId,username,event.target.currentTime);
        },3000);
    })
    .on("ended",function(){
        setFinished(videoId, username);
        window.clearInterval(timer);
    })
}

function addDuration(videoId,username)
{
    $.post("ajax/addDuration.php", {videoId: videoId, username:username }, function(data){
        if(data !== null && data !== "")
        {
        alert(data);
        }

    })
}


function updateProgress(videoId, username, progress)
{
    $.post("ajax/updateDuration.php", {videoId: videoId, username:username, progress: progress }, function(data){
        if(data !== null && data !== "")
        {
        alert(data);
        }

    })
}



function setFinished(videoId, username)
{
    $.post("ajax/setFinished.php", {videoId: videoId, username:username}, function(data){
        if(data !== null && data !== "")
        {
        alert(data);
        }

    })
}


function setStartTime(videoId, username)
{
    $.post("ajax/getProgress.php", {videoId: videoId, username:username}, function(data){
        if(isNaN(data))
        {
            alert(data);
            return;
        }

        $("video").on("canplay",function(){
            this.currentTime=data;
            $("video").off("canplay");
        })

    })
}

function restartVideo()   /* func to restart video on click*/
{
    $("video")[0].currentTime = 0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}

function watchVideo(videoId)     /* func to play video*/
{
    window.location.href = "watch.php?id=" + videoId;
}

function showUpNext()  /*at end of video*/
{
    $(".upNext").fadeIn();
}