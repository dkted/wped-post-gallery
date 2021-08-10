<?php 
namespace WPED\Base;

class GraphQLController
{
	public function register()
	{
		add_action('graphql_register_types', [$this, 'registerTypes']);
	}


	public function registerTypes()
    {
        register_graphql_object_type('DktImage', [
            'fields' => [
                'id'            => [ 'type' => 'Int' ],
                'urls'          => [ 'type' => 'DktImageSizes' ],
            ]
        ]);

        register_graphql_object_type('DktImageSizes', [
            'fields' => [
                'thumbnail'     => ['type' => 'String'],
                'medium'        => ['type' => 'String'],
                'large'         => ['type' => 'String'],
                'full'          => ['type' => 'String'],
            ]
        ]);

        register_graphql_object_type('DktGallery', [
            'fields' => [
                'postId'            => [ 'type' => 'Int' ],
                'postTitle'         => [ 'type' => 'String' ],
                'postSlug'          => [ 'type' => 'String' ],
                'title'             => [ 'type' => 'String' ],
                'videoUrl'          => [ 'type' => 'String' ],
                'images'            => [ 'type' => ['list_of' => 'DktImage'] ],
                'featuredImageUrl'  => [ 'type' => 'String' ]
            ]
        ]);
  
        register_graphql_field('RootQuery', 'dktEvents', [
            'description'       => 'PREMIERE Events',
            'type'              => ['list_of'=>'DktGallery'],
            'args'              => [
                'postId'        => [ 'type' => 'Int' ]
            ],
            'resolve'           => function($source, $args, $context, $info) 
            {
                $query_args = [
                    'post_type'     => WPEDPG_POST_TYPE,
                    'post_status'   => 'publish',
                    'nopaging'      => true,
                ];
                
                $query = get_posts($query_args);
                $posts = [];
                
                foreach ($query as $post) {
                    $metas = get_post_meta( $post->ID, WPEDPG_METABOX_ID, true );
                    
                    $metas = is_array($metas)? $metas : ['images' => [], 'title' => ''];
                    $images = [];
                
                    foreach ($metas['images'] as $imageID) {
                        $images[] = [
                            'id' => $imageID,
                            'urls' => [
                                'thumbnail'     => wp_get_attachment_image_url($imageID, 'thumbnail'),
                                'medium'        => wp_get_attachment_image_url($imageID, 'medium'),
                                'large'         => wp_get_attachment_image_url($imageID, 'large'),
                                'full'          => wp_get_attachment_image_url($imageID, 'full'),
                            ],
                        ];
                    }

                    $featuredImageUrl = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full');
                
                    $posts[] = [
                        'postId'            => $post->ID,
                        'postTitle'         => $post->post_title,
                        'postSlug'          => $post->post_name,
                        'title'             => $metas['title'],
                        'videoUrl'          => $metas['video_url'],
                        'images'            => $images,
                        'featuredImageUrl'  => $featuredImageUrl,
                    ];
                }                

                return $posts;
            }
        ]);
    }
}