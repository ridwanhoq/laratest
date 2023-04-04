<?php

namespace Database\Seeders;

use App\Models\N;
use Illuminate\Database\Seeder;

class PnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        N::insert(
            [
                'title'         => 'Username invited you ',
                'body'          => 'Username invited you ',
                'has_buttons'   => true,
                'action'        => 'my_friend_group',
                'api_endpoint'  => '',
                'details'       =>
                [
                    'id'        => 1,
                    'title'     => 'My FG 1',
                    'status'    => true,
                ]
            ],
            [
                'title'         => 'Username invited you ',
                'body'          => 'Username invited you ',
                'has_buttons'   => false,
                'action'        => 'my_friend_group',
                'api_endpoint'  => '',
                'details'       =>
                [
                    'id'        => 2,
                    'title'     => 'My FG 2',
                    'status'    => false,
                ]
            ],
            [
                'title'         => 'Your user question approved ',
                'body'          => 'Your user question approved ',
                'has_buttons'   => false,
                'action'        => 'user_questions',
                'api_endpoint'  => '',
                'details'       =>
                [
                    'id'        => 1,
                    'title'     => 'My UQ 1',
                    'status'    => true,
                ]
            ],
            [
                'title'         => 'Your user question not approved ',
                'body'          => 'Your user question not approved ',
                'has_buttons'   => false,
                'action'        => 'user_questions',
                'api_endpoint'  => '',
                'details'       =>
                [
                    'id'        => 2,
                    'title'     => 'My UQ 2',
                    'status'    => false,
                ]
            ],
            [
                'title'         => 'Your poll question approved ',
                'body'          => 'Your poll question approved ',
                'has_buttons'   => false,
                'action'        => 'poll_questions',
                'api_endpoint'  => '',
                'details'       =>
                [
                    'id'        => 1,
                    'title'     => 'My PQ 1',
                    'status'    => false,
                ]
            ],
            [
                'title'         => 'Your user question not approved ',
                'body'          => 'Your user question not approved ',
                'has_buttons'   => false,
                'action'        => 'poll_questions',
                'api_endpoint'  => '',
                'details'       =>
                [
                    'id'        => 2,
                    'title'     => 'My PQ 2',
                    'status'    => false,
                ]
            ]
        );
    }
}
