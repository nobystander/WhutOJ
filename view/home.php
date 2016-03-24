<?php
    require_once('./view/template/header.php');
?>

<div id="home-carousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#home-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#home-carousel" data-slide-to="1"></li>
        <li data-target="#home-carousel" data-slide-to="2"></li>
        <li data-target="#home-carousel" data-slide-to="3"></li>
    </ol>

  <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        
        <div class="item active">
            <img src="../view/image/bg.jpg">
            <div class="carousel-caption first-carousel-caption">
                <div class="first-section-text">
                    <h1>啊四大四大</h1>
                    <p>啊四大岁</p>
                </div>
            </div>
        </div>
        
        <div class="item">
            <img src="../view/image/blue.png">
            <div class="carousel-caption">
                <img src="../view/image/a.png">
                <div class="section-text">
                    <h1>AAAAAA</h1>
                    <p>sadasd</p>
                </div>
            </div>
        </div>

        <div class="item">
            <img src="../view/image/yellow.png">
            <div class="carousel-caption">
                <img src="../view/image/c.png">
                <div class="section-text">
                    <h1>BBBBB</h1>
                    <p>sadasd</p>
                </div>
            </div>
        </div>

        <div class="item">
            <img src="../view/image/red.png">
            <div class="carousel-caption">
                <img src="../view/image/m.png">
                <div class="section-text">
                    <h1>CCCCCCC</h1>
                    <p>sadasd</p>
                </div>
            </div>
        </div>
      
    </div>

  <!-- Controls -->
    <a class="left carousel-control" href="#home-carousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#home-carousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<?php
    require_once('./view/template/footer.php');
?>