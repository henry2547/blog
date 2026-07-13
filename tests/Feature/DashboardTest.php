<?php

namespace Tests\Feature;

use App\Http\Controllers\BlogController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/dashboard')->assertOk();
    }

    public function test_authenticated_users_can_view_their_draft_posts(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        DB::table('posts')->insert([
            'user_id' => $user->id,
            'title' => 'Draft post example',
            'slug' => 'draft-post-example',
            'content' => 'Draft content',
            'excerpt' => 'Draft excerpt',
            'category' => 'technology',
            'tags' => 'draft',
            'status' => 'draft',
            'views' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('/blog/drafts')
            ->assertOk()
            ->assertSee('Draft post example');
    }

    public function test_authenticated_users_can_view_published_posts_from_other_users(): void
    {
        /** @var User $author */
        $author = User::factory()->create();
        Post::create([
            'user_id' => $author->id,
            'title' => 'Shared article',
            'slug' => 'shared-article',
            'content' => 'Published content',
            'excerpt' => 'A published post',
            'category' => 'culture',
            'tags' => 'news',
            'status' => 'published',
            'published_at' => now(),
            'views' => 0,
        ]);

        /** @var User $viewer */
        $viewer = User::factory()->create();

        $this->actingAs($viewer)
            ->get('/blog')
            ->assertOk()
            ->assertSee('Shared article');
    }

    public function test_authenticated_users_can_view_the_likes_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/blog/likes')
            ->assertOk()
            ->assertSee('Likes');
    }

    public function test_authenticated_users_can_view_the_comments_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/blog/comments')
            ->assertOk()
            ->assertSee('Comments');
    }

    public function test_authenticated_users_can_comment_on_a_post(): void
    {
        /** @var User $author */
        $author = User::factory()->create();
        $post = Post::create([
            'user_id' => $author->id,
            'title' => 'Commentable article',
            'slug' => 'commentable-article',
            'content' => 'This post can be commented on.',
            'excerpt' => 'Commentable excerpt',
            'category' => 'lifestyle',
            'tags' => 'comment',
            'status' => 'published',
            'published_at' => now(),
            'views' => 0,
        ]);

        /** @var User $commenter */
        $commenter = User::factory()->create();

        $this->actingAs($commenter)
            ->post(route('blog.comment', $post), [
                'body' => 'Nice post!',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $commenter->id,
            'body' => 'Nice post!',
        ]);
    }

    public function test_publishing_a_post_sets_the_status_to_published(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        Auth::login($user);

        $request = new Request();
        $request->setMethod('POST');
        $request->request->add([
            'title' => 'Published article',
            'content' => 'This article should be published.',
            'category' => 'technology',
            'excerpt' => 'Excerpt',
            'action' => 'publish',
        ]);

        $controller = new BlogController();
        $controller->store($request);

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'title' => 'Published article',
            'status' => 'published',
        ]);
    }

    public function test_updating_a_post_with_publish_action_sets_it_to_published(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Draft article',
            'slug' => 'draft-article',
            'content' => 'Draft content',
            'excerpt' => 'Draft excerpt',
            'category' => 'business',
            'tags' => 'draft',
            'status' => 'draft',
            'views' => 0,
        ]);

        Auth::login($user);

        $request = new Request();
        $request->setMethod('PUT');
        $request->request->add([
            'title' => 'Draft article',
            'content' => 'Draft content',
            'category' => 'business',
            'excerpt' => 'Draft excerpt',
            'action' => 'publish',
        ]);

        $controller = new BlogController();
        $controller->update($request, $post);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'published',
        ]);
    }

    public function test_authenticated_users_can_view_the_statistics_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/blog/statistics')
            ->assertOk()
            ->assertSee('Statistics');
    }

    public function test_authenticated_users_can_view_the_followers_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/blog/followers')
            ->assertOk()
            ->assertSee('Followers');
    }

    public function test_authenticated_users_can_view_a_profile_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/blog/profile/' . $user->id)
            ->assertOk()
            ->assertSee($user->name);
    }
}