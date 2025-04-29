<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\Post;
use App\Helpers\UploadFile;

use function App\Helpers\clean;
use function App\Helpers\escape_html_attr;

class PostController extends BaseController
{
    private Post $post;

    public function __construct()
    {
        $this->post = new Post();

        $this->layout = new Layout(
            new Navbar([
                'brand' => 'IET_Post',
                'items' => [
                    ['label' => 'Logout', 'href' => '#'],
                    ['label' => 'Profile', 'href' => '#']
                ]
            ]),
            new Sidebar([
                'items' => [
                    ['label' => 'Create Post', 'href' => route('ietpost.create')],
                    ['label' => 'My Posts', 'href' => route('ietpost.my')],
                    ['label' => 'Archived', 'href' => route('ietpost.archived')],
                    ['label' => 'All Posts', 'href' => route('ietpost.all')],
                    ['label' => 'Meetings', 'href' => route('ietmeeting.create')]
                ]
            ])
        );
    }

    public function createPostForm(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }

        echo $this->render('posts/create', [
            'title' => 'Create New Post',
        ]);
    }

    public function storePost(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }

        $title      = clean('default', $_POST['title'] ?? '');
        $content    = clean('text', $_POST['content'] ?? '');
        $mediaType  = clean('default', $_POST['media_type'] ?? 'image');
        $keywords   = clean('default', $_POST['keywords'] ?? '');
        $visibility = clean('default', $_POST['visibility'] ?? 'published');

        $uploadCategory = in_array($mediaType, ['image', 'video']) ? $mediaType : 'general';
        $uploadResult = UploadFile::upload($uploadCategory, 'media');

        if (!$uploadResult['success']) {
            $_SESSION['errors']['upload'] = $uploadResult['error'];
            redirect(route('ietpost.create'));
            return;
        }

        $post = new Post();
        $post->user_id     = (int)($_SESSION['user_id'] ?? 0);
        $post->title       = $title;
        $post->content     = $content;
        $post->media_type  = $mediaType;
        $post->media_path  = $uploadResult['filename'];
        $post->keywords    = $keywords;
        $post->visibility  = in_array($visibility, ['published', 'archived']) ? $visibility : 'published';

        if ($post->store()) {
            if ($post->store()) {
                $_SESSION['success'] = '✅ Post created successfully.';
                redirect(route('ietpost.single', ['id' => $post->id ?? 0])); // fallback to 0 if ever null
            }
            
        } else {
            $_SESSION['errors']['store'] = '❌ Failed to create post.';
            redirect(route('ietpost.create'));
        }
    }

    public function index(): void
    {
        $posts = $this->post->fetchAll();

        echo $this->render('posts/index', [
            'title' => '🗂 All Posts',
            'posts' => $posts,
        ]);
    }

    public function singlePost(int $id): void
    {
        $post = $this->post->fetchById($id);

        if (!$post || $post->visibility !== 'published') {
            http_response_code(404);
            echo $this->render('errors/404', ['title' => 'Post Not Found']);
            return;
        }

        echo $this->render('posts/show', [
            'title' => $post->title,
            'post' => $post,
        ]);
    }
    public function myPosts(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }
    
        $userId = (int)$_SESSION['user_id'];
        $posts = $this->post->fetchByUser($userId);
    
        if (!$posts) {
            $_SESSION['error'] = 'No posts yet. <a href="' . route('ietpost.create') . '" class="text-blue-500 underline">Create one</a>.';
        }
    
        $this->layout = new Layout(
            new Navbar([
                'brand' => 'IET_Post',
                'items' => [
                    ['label' => 'Dashboard', 'href' => route('ietdashboard')],
                    ['label' => 'Logout', 'href' => route('auth.logout')]
                ]
            ]),
            new Sidebar([
                'items' => [
                    ['label' => 'Create Post', 'href' => route('ietpost.create')],
                    ['label' => 'My Posts', 'href' => route('ietpost.my')],
                    ['label' => 'Archived', 'href' => route('ietpost.archived')],
                    ['label' => 'All Posts', 'href' => route('ietpost.all')],
                    ['label' => 'Meetings', 'href' => route('ietmeeting.create')],
                ]
            ])
        );
    
        echo $this->render('posts/index', [
            'title' => '📂 My Posts',
            'posts' => $posts
        ]);
    }
    

    public function myArchivedPosts(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }

        $posts = $this->post->fetchArchivedByUser((int)$_SESSION['user_id']);
        echo $this->render('posts/index', [
            'title' => '🗄 Archived Posts',
            'posts' => $posts
        ]);
    }
}
