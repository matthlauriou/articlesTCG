<?php
	
function derniersArtilcesAccueil($atts){

    extract( shortcode_atts( array(
		'num' => '5',
		'order' => 'DESC',
		'orderby' => 'date',
	), $atts) );

    $output= "<head>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
			</head>
	<body>
	<h2>L'actualité du club</h2>";

	$query = array();

	if ( $num )
		$query[] = 'numberposts=' . $num;

	if ( $order )
		$query[] = 'order=' . $order;

	if ( $orderby )
		$query[] = 'orderby=' . $orderby;

	$posts_to_show = get_posts( implode( '&', $query ) );

	foreach ($posts_to_show as $post_to_show) {
		$post_id = $post_to_show->ID ;
		$permalink = get_permalink( $post_id );

		$output = $output ."<figure>
		<div>
			<table>
				<thead>
					<tr>
						<th>
							<a href ='{$permalink}' title='{$post_to_show->post_title}' class='lastPost_text_deco_none lastPost_font_size_large'>{$post_to_show->post_title} </a>
						</th>
					</tr>
				</thead>
			</table>
		";
		
		if(has_post_thumbnail($post_id) !=''){
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
			$output = $output ."<table>
			<tbody>
				<tr>
					<td>
						<img id='thumbnail' src='{$image[0]}' alt='image_thumbnail' class=''/>
					</td>";
		}else {
			$firstImage = '';
			ob_start();
			ob_end_clean();
			$outputImage = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_to_show->post_content, $matches);
			$firstImage = $matches [1];
			if(empty($firstImage)){ 
				// met en place une image par default si l'article n'en contient pas
				$firstImage = plugin_dir_url(dirname(__FILE__)).'img/default.jpg';
				$output = $output ."<table>
				<tbody>
					<tr>
						<td>
							<img id='thumbnail' src='{$firstImage}' alt='image_thumbnail' class='lastPost_img_size'/>
						</td>";
			}else{
				$output = $output ."<table>
				<tbody>
					<tr>
						<td>
							<img id='thumbnail' src='{$firstImage[0]}' alt='image_thumbnail' class='lastPost_img_size'/>
						</td>";

			}
		}

        $content = $post_to_show->post_content;
        $resumerContenu = substr($content, 0, 300);
		$readMe = plugin_dir_url(dirname(__FILE__)).'img/open-book.png';
        $output = $output ." <td>{$resumerContenu}...</td>
						</tr>
						<tr>
							<td colspan = 2 class='lastPost_text_align_right'>
								<a href =\"window.location.href='{$permalink}';\" class='lastPost_text_deco_none'><img src='{$readMe}' alt='readMe' class='lastPost_img_icon_size'/> En savoir plus</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</figure>";
	}

	$lienTousArticles = '?post_type=post';
	$readAll = plugin_dir_url(dirname(__FILE__)).'img/book.png';
	$output = $output ."<a href = '{$lienTousArticles}' class=''><img src='{$readAll}' alt='readAll' class='lastPost_img_icon_size'/> Voir les articles plus anciens</a>
	</body>";

    return  $output;
}
add_shortcode('derniersArticles','derniersArtilcesAccueil');

?>