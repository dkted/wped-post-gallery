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
                'url'           => [ 'type' => 'String' ],
            ]
        ]);

        register_graphql_object_type('DktGallery', [
            'fields' => [
                'postId'        => [ 'type' => 'Int' ],
                'postTitle'         => [ 'type' => 'String' ],
                'title'         => [ 'type' => 'String' ],
                'images'        => [ 'type' => ['list_of' => 'DktImage'] ],
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
                    'post_type' => WPEDPG_POST_TYPE,
                    'post_status' => 'publish',
                ];
                
                $query = get_posts($query_args);
                $posts = [];
                
                foreach ($query as $post) {
                    $metas = get_post_meta( $post->ID, WPEDPG_METABOX_ID, true );
                    
                    $metas = is_array($metas)? $metas : ['images' => [], 'title' => ''];
                    $images = [];
                
                    foreach ($metas['images'] as $image) {
                        $images[] = [
                            'id' => $image['id'],
                            'url' => wp_get_attachment_image_url($image['id'], 'full'),
                        ];
                    }
                
                    $posts[] = [
                        'postId'	=> $post->ID,
                        'postTitle' => $post->post_title,
                        'title' => $metas['title'],
                        'images' => $images
                    ];
                }                

                return $posts;
            }
        ]);
    }
}