<?php
//about theme info
add_action( 'admin_menu', 'educator_education_abouttheme' );
function educator_education_abouttheme() {    	
	add_theme_page( esc_html__('About Educator Education Theme', 'educator-education'), esc_html__('About Educator Education Theme', 'educator-education'), 'edit_theme_options', 'educator_education_guide', 'educator_education_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function educator_education_admin_theme_style() {
   wp_enqueue_style('educator-education-custom-admin-style', esc_url(get_template_directory_uri()) .'/inc/admin/admin.css');
}
add_action('admin_enqueue_scripts', 'educator_education_admin_theme_style');

//guidline for about theme
function educator_education_mostrar_guide() {
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>

<div class="wrapper-info">
	<div class="header">
	 	<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/logo.png" alt="<?php the_title(); ?> post thumbnail image">
	 	<h2><?php esc_html_e('Welcome to Advance Educator Education Theme', 'educator-education'); ?></h2>
 		<p><?php esc_html_e('Most of our outstanding theme is elegant, responsive, multifunctional, SEO friendly has amazing features and functionalities that make them highly demanding for designers and bloggers, who ought to excel in web development domain. Our Themeshopy has got everything that an individual and group need to be successful in their venture.', 'educator-education'); ?></p>
		<div class="main-button">
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_BUY_NOW ); ?>"><?php esc_html_e('Buy Now', 'educator-education'); ?></a>
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_LIVE_DEMO ); ?>"><?php esc_html_e('Live Demo', 'educator-education'); ?></a>
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_PRO_DOC ); ?>"><?php esc_html_e('Pro Documentation', 'educator-education'); ?></a>
		</div>
	</div>
	<div class="button-bg">
		<button role="tab" class="tablink" onclick="openPage('Home', this, '')"><?php esc_html_e('Lite Theme Setup', 'educator-education'); ?></button>
		<button role="tab" class="tablink" onclick="openPage('Contact', this, '')"><?php esc_html_e('Premium Theme info', 'educator-education'); ?></button>
	</div>
	<div id="Home" class="tabcontent tab1">
	  	<h3><?php esc_html_e('How to set up homepage', 'educator-education'); ?></h3>
	  	<div class="sec-button">
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_FREE_DOC ); ?>"><?php esc_html_e('Documentation', 'educator-education'); ?></a>
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_CONTACT ); ?>"><?php esc_html_e('Support', 'educator-education'); ?></a>
			<a href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Start Customizing', 'educator-education'); ?></a>
		</div>
	  	<div class="documentation">
		  	<div class="image-docs">
				<ul>
					<li> <b><?php esc_html_e('Step 1.', 'educator-education'); ?></b> <?php esc_html_e('Follow these instructions to setup Home page.', 'educator-education'); ?></li>
					<li> <b><?php esc_html_e('Step 2.', 'educator-education'); ?></b> <?php esc_html_e(' Create Page to set template: Go to Dashboard >> Pages >> Add New Page.Label it "home" or anything as you wish. Then select template "home-page" from template dropdown.', 'educator-education'); ?></li>
				</ul>
		  	</div>
		  	<div class="doc-image">
		  		<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/home-page-template.png" alt="<?php the_title(); ?> post thumbnail image">	
		  	</div>
		  	<div class="clearfixed">
				<div class="doc-image1">
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/set-front-page.png" alt="<?php the_title(); ?> post thumbnail image">	
			    </div>
			    <div class="image-docs1">
				    <ul>
						<li> <b><?php esc_html_e('Step 3.', 'educator-education'); ?></b> <?php esc_html_e('Set the front page: Go to Setting -> Reading --> Set the front page display static page to home page', 'educator-education'); ?></li>
					</ul>
			  	</div>
			</div>
		</div>
	</div>
	<div id="Contact" class="tabcontent">
	 	<h3><?php esc_html_e('Premium Theme Info', 'educator-education'); ?></h3>
	  	<div class="sec-button">
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_BUY_NOW ); ?>"><?php esc_html_e('Buy Now', 'educator-education'); ?></a>
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_LIVE_DEMO ); ?>"><?php esc_html_e('Live Demo', 'educator-education'); ?></a>
			<a href="<?php echo esc_url( EDUCATOR_EDUCATION_PRO_DOC ); ?>"><?php esc_html_e('Pro Documentation', 'educator-education'); ?></a>
		</div>
	  	<div class="features-section">
	  		<div class="col-4">
	  			<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/screenshot.jpg" alt="<?php the_title(); ?> post thumbnail image">
	  			<p><?php esc_html_e( 'Whether you are a tutor or running any educational institute; this Free Educator WordPress Theme is going to make it extremely easy for you to have a professional web appearance. Your website has an important role to play when it comes to the success of your profession or Educator Education since it gives your audience an idea about your work and lets them decide whether to put their trust in your services or not. As this theme is typically designed for education and teaching-based websites, you will hardly need to modify it for creating your web page. Many basic functionalities have been included in the design to make it practically ready for serving as a full-fledged teaching and learning site. However, this Free Educator WordPress Theme from Themshopy includes some scope for you to try changing a few basic things of the design and make your website have your own taste.For that, there are options given for colors, typography, title, fonts, etc. You may also add your logo to the website to make it look even more professional. Integration with the Wocmmerce plugin is going to be a massive plus for your website. With this, you will not only be able to sell your study material online and video lectures subscription online but also get some revenue from the same. Moreover, adding more features to your existing site is also easy with this teme as it is made plugin compatible supporting most of the free as well as premium plugins. With the key details highlighting contact info at the top of the page, the slider also catches the attention by displaying pictures of your work with Call to Action (CTAs) nicely placed on it that will take care of the conversions. Free Educator WordPress Theme is well-equipped with all the elements needed for a great web presence.', 'educator-education' ); ?></p>
	  		</div>
	  		<div class="col-4">
	  			<h4><?php esc_html_e( 'Theme Features', 'educator-education' ); ?></h4>
				<ul>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Theme options using customizer API', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Responsive Design', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Favicon, Logo, Title and Tagline Customization', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Advanced Color Options and Color Pallets', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( '100+ Font Family Options', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Advance Slider with a Number of Slider Images Upload Option Available.', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Support to Add Custom CSS/JS', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'SEO Friendly', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Pagination Option', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Compatible With Different WordPress Famous Plugins Like Contact Form 7 and Woocommerce', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Enable-Disable Options on All Sections', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Footer Customization Options', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Fully Integrated with Font Awesome Icon', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Short Codes', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Background Image Option', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Custom Page Templates', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Featured Product Images, HD Images and Video display', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Allow To Set Site Title, Tagline, Logo', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Make Post About Firms News, Events, Achievements and So On.', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Left and Right Sidebar', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Sticky Post & Comment Threads', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Parallax Image-Background Section', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Custom Backgrounds, Colors, Headers, Logo & Menu', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Customizable Home Page', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Full-Width Template', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Gallery, Banner & Post Type Plugin Functionality', 'educator-education' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Advance Social Media Feature', 'educator-education' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script>
	function openPage(pageName,elmnt,color) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablink");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].style.backgroundColor = "";
	    }
	    document.getElementById(pageName).style.display = "block";
	    elmnt.style.backgroundColor = color;
	}
</script>

<?php } ?>