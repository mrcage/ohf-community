<?php

namespace App\Http\Controllers\Fundraising\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fundraising\StoreComment;
use App\Http\Resources\Comment as CommentResource;
use App\Models\Comment;
use App\Models\Fundraising\Donor;
use Illuminate\Http\Request;

class DonorCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Donor $donor, Request $request)
    {
        $this->authorize('view', $donor);
        $this->authorize('viewAny', Comment::class);

        return CommentResource::collection($donor->comments()
            ->orderBy('created_at', 'asc')
            ->get())
            ->additional([
                'meta' => [
                    'can_create' => $request->user()->can('create', Comment::class)
                ]
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Donor $donor, StoreComment $request)
    {
        $this->authorize('view', $donor);
        $this->authorize('create', Comment::class);

        $comment = new Comment();
        $comment->setCurrentUser();
        $comment->content = $request->content;
        $donor->addComment($comment);

        return (new CommentResource($comment))
            ->additional([
                'message' => __('Comment added.'),
            ]);
    }
}
