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



        $response = Http::withoutVerifying()->get("https://api.github.com/users/alessandrosaladino-tech/repos?sort=created&direction=asc&per_page=100");


        $repositories = $response->json();

        foreach ($repositories as $repository) {

            $project = Project::updateOrCreate(
                [
                    'title' => $repository['name']
                ],
                [
                    'title' => $repository['name'],
                    'slug' => Project::generateSlug($repository['name']),
                    'description' => $repository['description'],
                    'cover_image' => '',
                    'github_link' => $repository['html_url']
                ]
            );

            $lang_response = Http::withoutVerifying()->get("https://api.github.com/repos/{$author}/{$repository['name']}/languages");;


            $project_technologies = $lang_response->json();

            foreach ($project_technologies as $language) {
                $technology = Technology::updateOrCreate(
                    ['name' => $language],
                    [
                        'slug' => Technology::generateSlug($language)
                    ],
                );

                $technology_ids[] = Technology::where('slug', $technology->slug)->first()->id;
            }

            $project->technologies()->sync($technology_ids);

            
            $project->type_id = rand(1, 5);
            $project->save();
        }
        return to_route('admin.projects.index')->with('message', 'Fetch Data From GitHub Successfully');
    }
}