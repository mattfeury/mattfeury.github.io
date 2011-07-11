<? include "templates/head.php" ?>
<script type="text/javascript" src="javascripts/sunburst.js"></script>
<script type="text/javascript" src="javascripts/mattfeury.js"></script> 
<? include "templates/header.php" ?>
<canvas id="binary" width="500" height="500"></canvas>  
<canvas id="beams" width="500" height="500"></canvas>  
<img src="images/corner-trans2.png" id="gramophone" />	
<nav>
  <h3>mattfeury.com</h3>
  Web Developer / Sound Experimentalist
  <p class="break" />
  <p>
    I dwell in the intersection of technology and music.
  </p>
  <p>
    My current project is with <a target="_blank" rel="external" href="http://www.openstudy.com/">OpenStudy</a>.
  </p>
</nav>

<section class="pane third" style="visibility: hidden;">
  <div class="inline-styles-are-the-devils-tool" style="display: none;">
    <h2>Links</h2>
    <div class="base">
      <p>
         <strong>quit peekin'</strong>, 
      </p>
      
    </div>
  </div>
</section>
<section class="pane third">
  <h2>Robot</h2>

    <div>
      <h3>Projects:</h3>
      <ul id="projects">
        <li><a href="/audiolizer/index.php" rel="external">Audiolizer</a><div class="details">(co-creator)</div></li>
        <li><a target="_blank" href="http://www.music.gatech.edu/" rel="external">Georgia Tech School of Music</a><div class="details">(lead designer, lead developer)</div></li>
        <li><a target="_blank" href="http://www.meedeor.com/" rel="external">MEEDEOR</a><div class="details">(former developer, Helvetica advocate)</div></li>
        
      </ul>
    </div>

    <p>
      Find me on 
      <a href="http://www.github.com/mattfeury" target="_blank">Github</a>.
    </p>

    <h3>Dancing Ghost:</h3>
    <img id="ozmo" src="12-oz.gif" />
  
</section>

<section class="pane human third">
  <h2>Human</h2>
  <div>
    <h3><a href="http://www.twitter.com/soundandfeury" target="_blank">Twitter</a></h3>
    <ul id="tweets"></ul>
    <p class="break" />
    <h3><a href="http://www.last.fm/user/mattfeury" target="_blank">last.fm</a></h3>
    <ul id="albums"></ul>
  </div>				
</section>
<? include "templates/footer.php" ?>
