<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Str;

class GitHubController extends Controller
{
    public function fetchRepositories()
    {
        $author = env('GITHUB_USERNAME', 'alessandrosaladino-tech');

        $response = Http::withoutVerifying()->withHeader('Authorization', 'Bearer ' . env('GITHUB_API_TOKEN'))->get("https://api.github.com/users/{$author}/repos?sort=created&direction=asc&per_page=100");

        $repositories = $response->json();

        foreach ($repositories as $repository) {
            $project = Project::updateOrCreate(
                [
                    'title' => $repository['name']
                ],
                [
                    'slug' => Project::generateSlug($repository['name']),
                    'description' => $repository['description'],
                    'cover_image' => 'placeholders/ilya-pavlov-OqtafYT5kTw-unsplash.jpg',
                    'github_link' => $repository['html_url']
                ]
            );

            $lang_response = Http::withoutVerifying()->withHeader('Authorization', 'Bearer ' . env('GITHUB_API_TOKEN'))->get("https://api.github.com/repos/{$author}/{$repository['name']}/languages");

            if ($lang_response->successful()) {

                $languagesData = $lang_response->json();

                $totalSize = array_sum($languagesData);

                foreach ($languagesData as $language => $size) {
                    $percentage = ($size / $totalSize) * 100;

                    $technology = Technology::firstOrCreate(
                        ['name' => $language],
                        [
                            'slug' => Technology::generateSlug($language),
                        ]
                    );
                }

                
                $project->type_id = rand(1, 5);
                $project->save();
            }
        }
        return to_route('admin.projects.index')->with('message', 'Fetch Data From GitHub Successfully');
    }
}