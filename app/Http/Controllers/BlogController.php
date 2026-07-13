<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show the dashboard with real blog statistics and recent posts.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $userPosts = Post::query()
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $publishedPosts = $userPosts->where('status', 'published');
        $draftPosts = $userPosts->where('status', 'draft');

        $topPosts = Post::query()
            ->where('status', 'published')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        $stats = [
            'published_posts' => $publishedPosts->count(),
            'draft_posts' => $draftPosts->count(),
            'total_views' => $publishedPosts->sum('views'),
            'latest_published' => $publishedPosts->sortByDesc('published_at')->first(),
        ];

        return view('dashboard', compact('user', 'userPosts', 'topPosts', 'stats'));
    }

    /**
     * Show blog categories and counts.
     */
    public function categories()
    {
        $categories = Post::query()
            // ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, count(*) as posts_count')
            ->groupBy('category')
            ->orderByDesc('posts_count')
            ->get();

        return view('blog.categories', compact('categories'));
    }

    /**
     * Show engagement stats for likes and views.
     */
    public function likes()
    {
        $posts = Post::query()
            ->withCount('likes')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('blog.likes', compact('posts'));
    }

    /**
     * Show recent comments activity for the current user.
     */
    public function comments()
    {
        $comments = Comment::with(['post', 'user'])
            ->whereHas('post', fn ($query) => $query->where('user_id', Auth::id()))
            ->latest()
            ->get();

        return view('blog.comments', compact('comments'));
    }

    /**
     * Show blog statistics for the authenticated user.
     */
    public function statistics()
    {
        $posts = Post::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $stats = [
            'published' => $posts->where('status', 'published')->count(),
            'drafts' => $posts->where('status', 'draft')->count(),
            'views' => $posts->sum('views'),
            'top_viewed' => $posts->where('status', 'published')->sortByDesc('views')->first(),
        ];

        return view('blog.statistics', compact('posts', 'stats'));
    }

    /**
     * Show followers and follow suggestions.
     */
    public function followers()
    {
        $following = Follow::with('followed')->where('follower_id', Auth::id())->get();
        $followers = Follow::with('follower')->where('followed_id', Auth::id())->get();
        $suggestions = \App\Models\User::query()
            ->where('id', '!=', Auth::id())
            ->whereNotIn('id', $following->pluck('followed_id'))
            ->take(5)
            ->get();

        return view('blog.followers', compact('followers', 'following', 'suggestions'));
    }

    /**
     * Show another user's profile.
     */
    public function profile(\App\Models\User $user)
    {
        $posts = Post::query()
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->latest()
            ->get();

        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $likesCount = Post::query()->where('user_id', $user->id)->sum('likes_count');
        $isFollowing = Auth::check() && Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->exists();

        return view('blog.profile', compact('user', 'posts', 'followersCount', 'followingCount', 'likesCount', 'isFollowing'));
    }

    /**
     * Follow or unfollow a user.
     */
    public function follow(\App\Models\User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('info', 'You cannot follow yourself.');
        }

        $existing = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'You have unfollowed ' . $user->name . '.');
        }

        Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $user->id,
        ]);

        return back()->with('success', 'You are now following ' . $user->name . '.');
    }

    /**
     * Toggle a like on a post.
     */
    public function like(Post $post)
    {
        $like = Like::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);

        if (! $like->wasRecentlyCreated) {
            return back()->with('info', 'You already liked this post.');
        }

        $post->increment('likes_count');

        return back()->with('success', 'Liked post successfully.');
    }

    /**
     * Store a comment on a post.
     */
    public function comment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        $post->increment('comments_count');

        return back()->with('success', 'Comment added successfully.');
    }

    /**
     * Show the create post form
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Show all published posts from the database.
     */
    public function index()
    {
        $posts = Post::query()
            ->where('status', 'published')
            ->latest('published_at')
            ->latest()
            ->get();

        return view('blog.index', compact('posts'));
    }

    /**
     * Show all draft posts for the authenticated user
     */
    public function drafts()
    {
        $posts = Post::query()
            ->where('user_id', Auth::id())
            ->where('status', 'draft')
            ->latest()
            ->get();

        return view('blog.draft', compact('posts'));
    }

    protected function resolvePostAction(Request $request): string
    {
        $action = (string) $request->input('action', 'draft');

        return in_array($action, ['publish', 'published'], true) ? 'publish' : 'draft';
    }

    /**
     * Store a newly created post in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:160',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('featured_image')) {
                $imagePath = $request->file('featured_image')->store('posts', 'public');
            }

            $action = $this->resolvePostAction($request);
            $excerpt = $validated['excerpt'] ?? null;
            $tags = $validated['tags'] ?? null;

            // Create the post
            $post = Post::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'slug' => Post::generateSlug($validated['title']),
                'content' => $validated['content'],
                'excerpt' => $excerpt,
                'featured_image' => $imagePath,
                'category' => $validated['category'],
                'tags' => $tags,
                'status' => $action === 'publish' ? 'published' : 'draft',
                'published_at' => $action === 'publish' ? now() : null,
            ]);

            // Send progress updates via event stream
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $action === 'publish' ? 'Post published successfully!' : 'Draft saved successfully!',
                    'post_id' => $post->id,
                    'redirect' => route('dashboard'),
                ]);
            }

            return redirect()->route('dashboard')->with('success', 
                $action === 'publish' ? 'Post published successfully!' : 'Draft saved successfully!'
            );
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error saving post: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => 'Error saving post: ' . $e->getMessage()]);
        }
    }

    /**
     * Show preview of a post
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'excerpt' => 'nullable|string',
        ]);

        return response()->json([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'],
        ]);
    }

    /**
     * Show a single post
     */
    public function show(Post $post)
    {
        if ($post->status === 'draft' && $post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->load(['comments' => function ($query) {
            $query->latest()->with('user');
        }] );

        $post->forceFill([
            'views' => (int) $post->views + 1,
        ])->save();

        return view('blog.show', compact('post'));
    }

    /**
     * Show the edit form
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('blog.edit', compact('post'));
    }

    /**
     * Update a post
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:160',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
            }

            $action = $this->resolvePostAction($request);
            $excerpt = $validated['excerpt'] ?? null;
            $tags = $validated['tags'] ?? null;

            $post->update([
                ...$validated,
                'excerpt' => $excerpt,
                'tags' => $tags,
                'status' => $action === 'publish' ? 'published' : 'draft',
                'published_at' => $action === 'publish' ? now() : $post->published_at,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post updated successfully!',
                ]);
            }

            return back()->with('success', 'Post updated successfully!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating post: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => 'Error updating post: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a post
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        Post::destroy($post->getKey());

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
}

