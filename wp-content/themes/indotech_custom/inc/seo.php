<?php
/**
 * Indotech SEO & GEO (Generative Engine Optimization)
 *
 * Satu tempat untuk seluruh metadata head situs:
 *  - <meta name="description">
 *  - Open Graph + Twitter Card
 *  - JSON-LD @graph: Organization + LocalBusiness + WebSite (sitewide)
 *  - JSON-LD BreadcrumbList (kontekstual)
 *  - JSON-LD Article (single post)
 *
 * Tujuan GEO: memberi mesin AI (ChatGPT, Gemini, Perplexity) data entitas yang
 * terstruktur & faktual sehingga situs mudah dikutip sebagai sumber jawaban.
 *
 * ponytail: WP core sudah menangani <title> (title-tag), rel=canonical
 * (rel_canonical), dan robots (wp_robots). Modul ini hanya menambah yang hilang.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Data entitas perusahaan — sumber tunggal untuk seluruh schema.
 *
 * @return array
 */
function indotech_org_data() {
	static $data = null;
	if ( $data !== null ) {
		return $data;
	}

	$logo = get_template_directory_uri() . '/assets/images/logo-indotech-pt-besar.avif';

	$data = [
		'name'        => 'PT Indotech Berkah Abadi',
		'alt_name'    => 'Indotech',
		'url'         => home_url( '/' ),
		'logo'        => $logo,
		'email'       => indotech_opt( 'email', 'indotechberkahabadi@gmail.com' ),
		'founded'     => '2011',
		'description' => 'Produsen dan supplier B2B produk homecare, kimia laundry, car care, dan pewangi. Melayani grosir, distribusi, kemitraan, serta jasa maklon (private label) bersertifikat Halal MUI & izin edar Kemenkes RI ke seluruh Indonesia.',
		'address'     => [
			'street'   => 'Jongke Tengah No. 30, RT.01/RW.23, Sendangadi',
			'locality' => 'Mlati, Kabupaten Sleman',
			'region'   => 'Daerah Istimewa Yogyakarta',
			'postal'   => '55285',
			'country'  => 'ID',
		],
		// Nomor CS (E.164). Sesuai footer.php.
		'phones'      => [
			[ 'tel' => '+6287885590088', 'type' => 'sales',            'label' => 'CS Keagenan' ],
			[ 'tel' => '+6285559474797', 'type' => 'customer support', 'label' => 'CS Retail' ],
			[ 'tel' => '+6282215840088', 'type' => 'customer support', 'label' => 'CS Pelatihan' ],
		],
		'sameAs'      => [
			'https://www.instagram.com/orchidcareofficial',
			'https://www.facebook.com/indotechgroup/',
		],
	];

	return $data;
}

/**
 * Hasilkan meta description untuk konteks halaman saat ini.
 *
 * @return string
 */
function indotech_meta_description() {
	$org  = indotech_org_data();
	$desc = '';

	if ( is_front_page() || is_home() ) {
		$desc = get_bloginfo( 'description' );
		if ( ! $desc ) {
			$desc = $org['description'];
		}
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( has_excerpt( $post ) ) {
			$desc = get_the_excerpt( $post );
		} else {
			$desc = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 32, '…' );
		}
	} elseif ( is_post_type_archive() || is_category() || is_tag() || is_tax() ) {
		$desc = wp_strip_all_tags( get_the_archive_description() );
		if ( ! $desc ) {
			$desc = sprintf(
				'%s dari PT Indotech Berkah Abadi — supplier B2B produk homecare & kimia laundry terpercaya di Indonesia.',
				wp_strip_all_tags( get_the_archive_title() )
			);
		}
	} elseif ( is_search() ) {
		$desc = sprintf( 'Hasil pencarian untuk "%s" di situs PT Indotech Berkah Abadi.', get_search_query() );
	} elseif ( is_404() ) {
		$desc = 'Halaman tidak ditemukan. Jelajahi produk homecare dan layanan B2B PT Indotech Berkah Abadi.';
	}

	// Normalkan spasi & batasi ~160 karakter (best practice snippet).
	$desc = trim( preg_replace( '/\s+/', ' ', (string) $desc ) );
	if ( mb_strlen( $desc ) > 160 ) {
		$desc = rtrim( mb_substr( $desc, 0, 157 ) ) . '…';
	}

	return $desc;
}

/**
 * Gambar sosial (OG/Twitter) untuk konteks saat ini.
 *
 * @return string
 */
function indotech_social_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		$img = get_the_post_thumbnail_url( get_queried_object_id(), 'large' );
		if ( $img ) {
			return $img;
		}
	}
	return indotech_org_data()['logo'];
}

/**
 * Cetak meta description + Open Graph + Twitter Card.
 */
function indotech_output_meta_tags() {
	$org   = indotech_org_data();
	$desc  = indotech_meta_description();
	$image = indotech_social_image();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
	$title = wp_get_document_title();
	$type  = is_singular( [ 'post' ] ) ? 'article' : 'website';

	echo "\n<!-- Indotech SEO -->\n";

	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}

	// Open Graph
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( 'id_ID' ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( $org['name'] ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	}

	// Twitter
	printf( '<meta name="twitter:card" content="%s">' . "\n", esc_attr( 'summary_large_image' ) );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
	}
	echo "<!-- /Indotech SEO -->\n";
}
add_action( 'wp_head', 'indotech_output_meta_tags', 5 );

/**
 * Cetak satu blok JSON-LD @graph: Organization + LocalBusiness + WebSite.
 * Ini adalah inti GEO — entitas perusahaan yang bisa dikutip AI.
 */
function indotech_output_org_schema() {
	$org      = indotech_org_data();
	$org_id   = home_url( '/#organization' );
	$site_id  = home_url( '/#website' );

	$contact_points = [];
	foreach ( $org['phones'] as $p ) {
		$contact_points[] = [
			'@type'             => 'ContactPoint',
			'telephone'         => $p['tel'],
			'contactType'       => $p['type'],
			'name'              => $p['label'],
			'areaServed'        => 'ID',
			'availableLanguage' => [ 'Indonesian' ],
		];
	}

	$organization = [
		'@type'       => [ 'Organization', 'LocalBusiness' ],
		'@id'         => $org_id,
		'name'        => $org['name'],
		'alternateName' => $org['alt_name'],
		'url'         => $org['url'],
		'logo'        => [
			'@type' => 'ImageObject',
			'url'   => $org['logo'],
		],
		'image'       => $org['logo'],
		'description' => $org['description'],
		'email'       => $org['email'],
		'foundingDate' => $org['founded'],
		'telephone'   => $org['phones'][0]['tel'],
		'address'     => [
			'@type'           => 'PostalAddress',
			'streetAddress'   => $org['address']['street'],
			'addressLocality' => $org['address']['locality'],
			'addressRegion'   => $org['address']['region'],
			'postalCode'      => $org['address']['postal'],
			'addressCountry'  => $org['address']['country'],
		],
		'areaServed'  => [
			'@type' => 'Country',
			'name'  => 'Indonesia',
		],
		'contactPoint' => $contact_points,
		'sameAs'      => $org['sameAs'],
	];

	$website = [
		'@type'           => 'WebSite',
		'@id'             => $site_id,
		'url'             => $org['url'],
		'name'            => $org['name'],
		'inLanguage'      => 'id-ID',
		'publisher'       => [ '@id' => $org_id ],
		'potentialAction' => [
			'@type'       => 'SearchAction',
			'target'      => [
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			],
			'query-input' => 'required name=search_term_string',
		],
	];

	$graph = [
		'@context' => 'https://schema.org',
		'@graph'   => [ $organization, $website ],
	];

	indotech_print_jsonld( $graph );
}
add_action( 'wp_head', 'indotech_output_org_schema', 6 );

/**
 * BreadcrumbList untuk halaman non-home. Bantu AI & Google memahami hierarki.
 */
function indotech_output_breadcrumb_schema() {
	if ( is_front_page() ) {
		return;
	}

	$items = [ [ 'name' => 'Beranda', 'url' => home_url( '/' ) ] ];

	if ( is_singular() ) {
		$post_type = get_post_type();
		$pt_obj    = get_post_type_object( $post_type );
		if ( $pt_obj && $pt_obj->has_archive ) {
			$archive = get_post_type_archive_link( $post_type );
			if ( $archive ) {
				$items[] = [ 'name' => $pt_obj->labels->name, 'url' => $archive ];
			}
		}
		$items[] = [ 'name' => wp_strip_all_tags( get_the_title() ), 'url' => get_permalink() ];
	} elseif ( is_post_type_archive() || is_category() || is_tag() || is_tax() || is_archive() ) {
		$items[] = [ 'name' => wp_strip_all_tags( get_the_archive_title() ), 'url' => '' ];
	} elseif ( is_search() ) {
		$items[] = [ 'name' => 'Pencarian', 'url' => '' ];
	} else {
		return;
	}

	$list = [];
	foreach ( $items as $i => $item ) {
		$entry = [
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $item['name'],
		];
		if ( ! empty( $item['url'] ) ) {
			$entry['item'] = $item['url'];
		}
		$list[] = $entry;
	}

	indotech_print_jsonld( [
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $list,
	] );
}
add_action( 'wp_head', 'indotech_output_breadcrumb_schema', 7 );

/**
 * Article schema untuk single blog post — bantu AI kutip konten editorial.
 */
function indotech_output_article_schema() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$org   = indotech_org_data();
	$image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : $org['logo'];

	indotech_print_jsonld( [
		'@context'         => 'https://schema.org',
		'@type'            => 'Article',
		'headline'         => wp_strip_all_tags( get_the_title() ),
		'description'      => indotech_meta_description(),
		'image'            => $image,
		'datePublished'    => get_the_date( 'c' ),
		'dateModified'     => get_the_modified_date( 'c' ),
		'author'           => [
			'@type' => 'Person',
			'name'  => get_the_author(),
		],
		'publisher'        => [ '@id' => home_url( '/#organization' ) ],
		'mainEntityOfPage' => get_permalink(),
		'inLanguage'       => 'id-ID',
	] );
}
add_action( 'wp_head', 'indotech_output_article_schema', 8 );

/**
 * Cetak FAQPage schema dari daftar tanya-jawab.
 * GEO: format ini paling sering dikutip mesin AI sebagai jawaban langsung.
 *
 * @param array $faqs Daftar [ ['q' => string, 'a' => string], ... ]
 */
function indotech_render_faq_schema( array $faqs ) {
	$entities = [];
	foreach ( $faqs as $faq ) {
		if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
			continue;
		}
		$entities[] = [
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $faq['q'] ),
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( $faq['a'] ),
			],
		];
	}
	if ( ! $entities ) {
		return;
	}
	indotech_print_jsonld( [
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	] );
}

/**
 * Helper cetak JSON-LD dengan encoding aman (unicode & slash utuh).
 *
 * @param array $data
 */
function indotech_print_jsonld( array $data ) {
	echo '<script type="application/ld+json">'
		. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		. "</script>\n";
}

/**
 * robots.txt: izinkan eksplisit crawler AI/LLM agar situs boleh dikutip
 * sebagai sumber jawaban (GEO). Default WP sudah mengizinkan semua bot;
 * ini menegaskan niat + mudah dibaca. Hormati setelan privasi WP.
 *
 * @param string $output
 * @param string $public '1' bila "Search Engine Visibility" aktif.
 * @return string
 */
function indotech_robots_txt_ai( $output, $public ) {
	if ( '1' != $public ) {
		return $output; // Situs disetel privat — jangan undang bot.
	}
	$bots = [ 'GPTBot', 'ChatGPT-User', 'OAI-SearchBot', 'ClaudeBot', 'anthropic-ai', 'PerplexityBot', 'Google-Extended', 'CCBot' ];
	$out  = "\n# Crawler AI/LLM — situs boleh dijadikan sumber jawaban\n";
	foreach ( $bots as $bot ) {
		$out .= "User-agent: {$bot}\nAllow: /\n\n";
	}
	return $output . $out;
}
add_filter( 'robots_txt', 'indotech_robots_txt_ai', 10, 2 );

/**
 * Preconnect ke Google Fonts — hemat ~100-300ms waktu muat font.
 * ponytail: satu hook kecil, bukan plugin performa.
 */
function indotech_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = [ 'href' => 'https://fonts.googleapis.com' ];
		$hints[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' => '' ];
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'indotech_resource_hints', 10, 2 );
