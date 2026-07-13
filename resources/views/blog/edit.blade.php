<x-layouts::app :title="__('Edit Post')">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Edit Post</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Update your story</p>
        </div>

        <!-- Progress Dialog (Top Right) -->
        <div id="progressDialog" class="fixed top-6 right-6 z-50 hidden">
            <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-lg border border-neutral-200 dark:border-neutral-800 p-4 w-80">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-neutral-900 dark:text-white" id="progressTitle">Updating</span>
                        <span id="progressPercentage" class="text-xs font-semibold text-orange-600 dark:text-orange-400">0%</span>
                    </div>
                    <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 overflow-hidden">
                        <div id="progressBar" class="bg-gradient-to-r from-amber-500 to-orange-600 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span id="progressText" class="text-xs text-neutral-600 dark:text-neutral-400">Processing...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <form id="editForm" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title Section -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 space-y-4">
                <div>
                    <label for="title" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                        Post Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ $post->title }}"
                        placeholder="Enter your post title..."
                        class="w-full px-4 py-3 text-lg rounded-lg border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-500 dark:placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                        required
                    />
                    <div class="flex justify-between mt-2">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Make it catchy and descriptive</span>
                        <span id="titleCount" class="text-xs text-neutral-500 dark:text-neutral-400">{{ strlen($post->title) }}/100</span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                        Featured Image
                    </label>
                    <div id="imageUploadArea" class="relative border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-lg p-6 text-center hover:border-orange-500 dark:hover:border-orange-400 transition-colors cursor-pointer">
                        <input 
                            type="file" 
                            id="featured_image" 
                            name="featured_image" 
                            accept="image/*"
                            class="hidden"
                        />
                        <div id="uploadPlaceholder" class="space-y-2" style="{{ $post->featured_image ? 'display: none;' : '' }}">
                            <div class="text-3xl">🖼️</div>
                            <div>
                                <p class="text-sm font-semibold text-neutral-900 dark:text-white">Drop image here or click to select</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                        <div id="imagePreview" class="{{ $post->featured_image ? '' : 'hidden' }}">
                            <img id="previewImg" src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 space-y-4">
                <div>
                    <label for="content" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                        Post Content <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        placeholder="Write your amazing story here..."
                        rows="12"
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-500 dark:placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
                        required
                    >{{ $post->content }}</textarea>
                    <div class="flex justify-between mt-2">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Supports Markdown formatting</span>
                        <span id="contentCount" class="text-xs text-neutral-500 dark:text-neutral-400">{{ str_word_count($post->content) }} words</span>
                    </div>
                </div>

                <!-- Quick Formatting Buttons -->
                <div class="flex flex-wrap gap-2 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg">
                    <button type="button" class="px-3 py-1 text-sm font-medium rounded bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors" onclick="insertMarkdown('**', '**')">
                        <strong>Bold</strong>
                    </button>
                    <button type="button" class="px-3 py-1 text-sm font-medium rounded bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors" onclick="insertMarkdown('*', '*')">
                        <em>Italic</em>
                    </button>
                    <button type="button" class="px-3 py-1 text-sm font-medium rounded bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors" onclick="insertMarkdown('`', '`')">
                        Code
                    </button>
                    <button type="button" class="px-3 py-1 text-sm font-medium rounded bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors" onclick="insertMarkdown('# ', '\n')">
                        Heading
                    </button>
                    <button type="button" class="px-3 py-1 text-sm font-medium rounded bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors" onclick="insertMarkdown('- ', '\n')">
                        List
                    </button>
                </div>
            </div>

            <!-- Metadata Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Categories -->
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 space-y-4">
                    <label class="block text-sm font-semibold text-neutral-900 dark:text-white mb-3">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="technology" {{ $post->category === 'technology' ? 'checked' : '' }} class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">🚀 Technology</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="design" {{ $post->category === 'design' ? 'checked' : '' }} class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">🎨 Design</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="business" {{ $post->category === 'business' ? 'checked' : '' }} class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">💼 Business</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="culture" {{ $post->category === 'culture' ? 'checked' : '' }} class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">🌍 Culture</span>
                        </label>
                    </div>
                </div>

                <!-- Tags & Meta -->
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 space-y-4">
                    <div>
                        <label for="tags" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            Tags
                        </label>
                        <input 
                            type="text" 
                            id="tags" 
                            name="tags" 
                            value="{{ $post->tags }}"
                            placeholder="Add tags separated by commas..."
                            class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-500 dark:placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                        />
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">e.g. web design, tutorial, beginner</p>
                    </div>

                    <div>
                        <label for="excerpt" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            Excerpt
                        </label>
                        <textarea 
                            id="excerpt" 
                            name="excerpt" 
                            placeholder="Brief summary of your post..."
                            rows="3"
                            maxlength="160"
                            class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-500 dark:placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
                        >{{ $post->excerpt }}</textarea>
                        <div class="flex justify-between mt-2">
                            <span class="text-xs text-neutral-500 dark:text-neutral-400">For SEO and previews</span>
                            <span id="excerptCount" class="text-xs text-neutral-500 dark:text-neutral-400">{{ strlen($post->excerpt) }}/160</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button 
                    type="submit" 
                    name="action" 
                    value="publish"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200"
                >
                    ✨ Update & Publish
                </button>
                <button 
                    type="submit" 
                    name="action" 
                    value="draft"
                    class="flex-1 px-6 py-3 border-2 border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white font-bold rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                >
                    💾 Save as Draft
                </button>
                <a 
                    href="{{ route('blog.show', $post) }}"
                    class="flex-1 px-6 py-3 border-2 border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white font-bold rounded-lg text-center hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                >
                    ← Back
                </a>
            </div>
        </form>
    </div>

    <script>
        // Show progress dialog
        function showProgress(text, percentage, title = 'Updating') {
            const dialog = document.getElementById('progressDialog');
            const bar = document.getElementById('progressBar');
            const percent = document.getElementById('progressPercentage');
            const textEl = document.getElementById('progressText');
            const titleEl = document.getElementById('progressTitle');
            
            dialog.classList.remove('hidden');
            bar.style.width = percentage + '%';
            percent.textContent = percentage + '%';
            textEl.textContent = text;
            titleEl.textContent = title;
        }

        // Hide progress dialog
        function hideProgress() {
            document.getElementById('progressDialog').classList.add('hidden');
        }

        // Character counters
        document.getElementById('title').addEventListener('input', function() {
            document.getElementById('titleCount').textContent = this.value.length + '/100';
        });

        document.getElementById('content').addEventListener('input', function() {
            const words = this.value.trim().split(/\s+/).filter(w => w).length;
            document.getElementById('contentCount').textContent = words + ' words';
        });

        document.getElementById('excerpt').addEventListener('input', function() {
            document.getElementById('excerptCount').textContent = this.value.length + '/160';
        });

        // Image upload
        document.getElementById('imageUploadArea').addEventListener('click', function() {
            document.getElementById('featured_image').click();
        });

        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('uploadPlaceholder').classList.add('hidden');
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop
        document.getElementById('imageUploadArea').addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-orange-500');
        });

        document.getElementById('imageUploadArea').addEventListener('dragleave', function() {
            this.classList.remove('border-orange-500');
        });

        document.getElementById('imageUploadArea').addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-orange-500');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('featured_image').files = files;
                const event = new Event('change', { bubbles: true });
                document.getElementById('featured_image').dispatchEvent(event);
            }
        });

        // Insert markdown
        function insertMarkdown(before, after) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const selected = text.substring(start, end);

            const newText = text.substring(0, start) + before + selected + after + text.substring(end);
            textarea.value = newText;
            
            // Trigger input event for counter
            textarea.dispatchEvent(new Event('input'));
        }

        // Form submission with real progress
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitter = e.submitter;
            const action = submitter?.name === 'action' ? submitter.value : (formData.get('action') || 'draft');
            const isPublish = action === 'publish';

            if (submitter?.name === 'action') {
                formData.set('action', action);
            }
            
            showProgress('Validating changes...', 10, 'Updating');
            
            setTimeout(() => {
                showProgress('Processing images...', 30, 'Updating');
            }, 300);
            
            setTimeout(() => {
                showProgress('Compiling post...', 60, 'Updating');
            }, 700);
            
            setTimeout(() => {
                showProgress('Finalizing...', 85, 'Updating');
                
                // Submit form
                fetch('{{ route('blog.update', $post) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    showProgress('Complete!', 100, 'Updating');
                    setTimeout(() => {
                        hideProgress();
                        if (data.success) {
                            // Show success message
                            const successDiv = document.createElement('div');
                            successDiv.className = 'fixed top-20 right-6 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                            successDiv.textContent = data.message;
                            document.body.appendChild(successDiv);
                            
                            setTimeout(() => {
                                window.location.href = '{{ route('blog.show', $post) }}';
                            }, 1500);
                        } else {
                            alert('Error: ' + data.message);
                        }
                    }, 500);
                })
                .catch(error => {
                    hideProgress();
                    alert('Error: ' + error.message);
                });
            }, 1200);
        });
    </script>
</x-layouts::app>
