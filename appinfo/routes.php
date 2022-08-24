<?php

/**
 * Radio App
 *
 * @author Jonas Heinrich
 * @copyright 2021 Jonas Heinrich <onny@project-insanity.org>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

return [
    'resources' => [
  		'favorite' => ['url' => '/api/favorites'],
      'recent' => ['url' => '/api/recent'],
      'export' => ['url' => '/export'],
      'station' => ['url' => '/station'],
  	],
    'routes' => [

       // Web page templates
  	   [
          'name' => 'page#index',
          'url' => '/',
          'verb' => 'GET'
       ],
       [
          'name' => 'page#index',
          'url' => '/top',
          'verb' => 'GET',
          'postfix' => 'top'
       ],
       [
          'name' => 'page#index',
          'url' => '/recent',
          'verb' => 'GET',
          'postfix' => 'recent'
       ],
       [
          'name' => 'page#index',
          'url' => '/new',
          'verb' => 'GET',
          'postfix' => 'new'
       ],
       [
         'name' => 'page#index',
         'url' => '/favorites',
         'verb' => 'GET',
         'postfix' => 'favorites'
       ],
       [
         'name' => 'page#index',
         'url' => '/categories',
         'verb' => 'GET',
         'postfix' => 'categories'
       ],
       [
         'name' => 'page#index',
         'url' => '/search',
         'verb' => 'GET',
         'postfix' => 'search',
       ],

       // Api
       [
         'name' => 'favorite_api#preflighted_cors',
         'url' => '/api/0.1/{path}',
         'verb' => 'OPTIONS',
         'requirements' => ['path' => '.+']
       ],
       [
         'name' => 'recent_api#preflighted_cors',
         'url' => '/api/0.1/{path}',
         'verb' => 'OPTIONS',
         'requirements' => ['path' => '.+']
       ]

    ]
];
