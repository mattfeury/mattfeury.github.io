  </section>
	<footer>
	<?
	 $greetings = array('hey','hi','howdy doody','whats trappen','hows it hanging','sup');
	?>
	<h4><?= $greetings[array_rand($greetings)].", ".((isset($_SESSION['user'])) ? $_SESSION['user']->FirstName : 'nobody') ?></h4>
	</footer>

	
</div>

</body>

</html>
