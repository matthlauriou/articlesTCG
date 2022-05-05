<?php

function derniers_artilces_accueil($atts){

    extract( shortcode_atts( array(
		'num' => '5',
		'order' => 'DESC',
		'orderby' => 'date',
	), $atts) );

    $output= "<body>
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
		
		if(has_post_thumbnail($post_id)){
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
			$output = $output ."<table>
			<tbody>
				<tr>
					<td>
						<img id='thumbnail' src='{$image[0]}' alt='image_thumbnail' class=''/>
					</td>";
		}

        $content = $post_to_show->post_content;
        $resumerContenu = substr($content, 0, 300);
		
        $output = $output ." <td>{$resumerContenu}...</td>
			</tr>
			<tr>
				<td>
					<a href =\"window.location.href='{$permalink}';\" class='lastPost_text_deco_none'> En savoir plus</a>
				</td>
			</tr>
		</tbody>
		</table>
		</div>
		</figure>
		</body>";
	}

    return  $output;
}
add_shortcode('derniersArticles','derniers_artilces_accueil');

?>