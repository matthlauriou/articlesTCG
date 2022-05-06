<?php
	
function derniersArtilcesAccueil(){

    $output= "<h2 class='lastPost_text_align_center'>L'actualité du club</h2>";

	//récupération des articles selon les critères suivants
	$args = array(
		'numberposts' => 5,
		'orderby' =>'date',
		'order' => 'DESC',
		'post_type' =>'post'
	);

	//on récupere tous les posts correspondant aux critères
	$posts = get_posts($args);
	$espaceurTop = '';
    $indiceEspaceur = 0;

	// Pas de margin-top sur le premier tableau d'article'
	if($indiceEspaceur > 0) {
		$espaceurTop = 'lastPost_margin_top';
	}

	// on boucle dans les posts
	foreach ($posts as $post) {
		//on récupère l'id du post pour récupérer le lien vers l'article complet
		$post_id = $post->ID ;
		$permalink = get_permalink( $post_id );
		// on recupère le contenu de l'article 
		$content = $post->post_content;

		//on affiche le titre de l'article
		$output = $output ."<figure>
		<div class='lastPost_overflow lastPost_max_width lastPost_border_radius_20 $espaceurTop'>
			<table class='lastPost_margin_bottom latstPost_responsive_table'>
				<thead>
					<tr>
						<th colspan = 2 class='lastPost_backgroundColor_grisClair lastPost_text_align_left'>
							<a href ='{$permalink}' title='{$post->post_title}' class='lastPost_text_deco_none lastPost_font_size_large'> {$post->post_title} </a>
						</th>
					</tr>
				</thead>
			";
		// on verifie si l'article a une 1 image feature
		if(has_post_thumbnail($post_id) !=''){
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
			//si oui on l'affiche
			$output = $output ."
			<tbody>
				<tr>
					<td class='lastPost_vertical_align lastPost_text_align_center lastPost_w30 '>
						<img id='thumbnail' src='{$image[0]}' alt='image_thumbnail'/>
					</td>";
		} else {
			// on verifie si l'article a au moins une 1 image
			$firstImage = '';
			ob_start();
			ob_end_clean();
			$outputImage = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
			$firstImage = $matches [1];

			if(empty($firstImage)){ 
				// met en place une image par default si l'article n'en contient pas
				$firstImage = plugin_dir_url(dirname(__FILE__)).'img/default.jpg';
				$output = $output ."
				<tbody>
					<tr>
						<td class='lastPost_vertical_align lastPost_text_align_center lastPost_w30 '>
							<img id='thumbnail' src='{$firstImage}' alt='image_thumbnail' class=' lastPost_img_size'/>
						</td>";
			} else {
				//on affiche la première image poster dans l'article
				$output = $output ."
				<tbody>
					<tr>
						<td class='lastPost_vertical_align lastPost_text_align_center lastPost_w30 '>
							<img id='thumbnail' src='{$firstImage[0]}' alt='image_thumbnail' class=' lastPost_img_size'/>
						</td>";
			}
		}
		
		//on retire les images
		$contetnSansImage = preg_replace('/<img[^>]+./','',$content);
		//on créer un resumer
		$resumerContenuSansImage = substr($contetnSansImage, 0, 300);
		$readMe = plugin_dir_url(dirname(__FILE__)).'img/open-book.png';
		// on affiche qu'un resumé du texte
        $output = $output ." <td class='lastPost_w70 lastPost_vertical_align'>{$resumerContenuSansImage}...</td>
						</tr>
						<tr>
							<td colspan = 2 class='lastPost_text_align_right'>
								<a href ='{$permalink}' class='lastPost_text_deco_none'><img src='{$readMe}' alt='readMe' class='lastPost_img_icon_size'/> En savoir plus... </a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</figure>";
		
		$indiceEspaceur++;
	}
	// on redirige vers la page contenant tous les posts
	$lienTousArticles = '?post_type=post';
	$readAll = plugin_dir_url(dirname(__FILE__)).'img/book.png';
	$output = $output ."<div class='lastPost_a'>
	<a href = '{$lienTousArticles}'><img src='{$readAll}' alt='readAll' class='lastPost_img_icon_size'/><strong> Voir les articles plus anciens</strong></a>
	</div>";

    return  $output;
}
add_shortcode('derniersArticles','derniersArtilcesAccueil');

?>