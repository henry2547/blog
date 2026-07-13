<x-layouts::app :title="__('Create New Post')">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Create New Post</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Share your story with the world</p>
        </div>

        <!-- Progress Dialog (Top Right) -->
        <div id="progressDialog" class="fixed top-6 right-6 z-50 hidden">
            <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-lg border border-neutral-200 dark:border-neutral-800 p-4 w-80">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-neutral-900 dark:text-white" id="progressTitle">Saving Draft</span>
                        <span id="progressPercentage" class="text-xs font-semibold text-orange-600 dark:text-orange-400">0%</span>
                    </div>
                    <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 overflow-hidden">
                        <div id="progressBar" class="bg-gradient-to-r from-amber-500 to-orange-600 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span id="progressText" class="text-xs text-neutral-600 dark:text-neutral-400">Initializing...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <form id="postForm" class="space-y-6" enctype="multipart/form-data">
            @csrf

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
                        placeholder="Enter your post title..."
                        class="w-full px-4 py-3 text-lg rounded-lg border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-500 dark:placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                        required
                    />
                    <div class="flex justify-between mt-2">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Make it catchy and descriptive</span>
                        <span id="titleCount" class="text-xs text-neutral-500 dark:text-neutral-400">0/100</span>
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
                        <div id="uploadPlaceholder" class="space-y-2">
                            <div class="text-3xl">🖼️</div>
                            <div>
                                <p class="text-sm font-semibold text-neutral-900 dark:text-white">Drop image here or click to select</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                        <div id="imagePreview" class="hidden">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg">
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
                    ></textarea>
                    <div class="flex justify-between mt-2">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Supports Markdown formatting</span>
                        <span id="contentCount" class="text-xs text-neutral-500 dark:text-neutral-400">0 words</span>
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
                            <input type="radio" name="category" value="technology" class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">🚀 Technology</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="design" class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">🎨 Design</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="business" class="w-4 h-4" />
                            <span class="text-neutral-900 dark:text-white">💼 Business</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="category" value="culture" class="w-4 h-4" />
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
                        ></textarea>
                        <div class="flex justify-between mt-2">
                            <span class="text-xs text-neutral-500 dark:text-neutral-400">For SEO and previews</span>
                            <span id="excerptCount" class="text-xs text-neutral-500 dark:text-neutral-400">0/160</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
                <button type="button" id="previewBtn" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-100 dark:bg-blue-900/40 text-blue-900 dark:text-blue-300 font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/60 transition-colors">
                    👁️ Preview Post
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button 
                    type="submit" 
                    name="action" 
                    value="publish"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200"
                >
                    ✨ Publish Post
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
                    href="{{ route('dashboard') }}"
                    class="flex-1 px-6 py-3 border-2 border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white font-bold rounded-lg text-center hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                >
                    ← Back
                </a>
            </div>
        </form>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative bg-white dark:bg-neutral-900 rounded-xl max-w-3xl max-h-96 overflow-y-auto w-full">
            <div class="sticky top-0 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-800 p-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Preview</h2>
                <button onclick="closePreview()" class="text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white">✕</button>
            </div>
            <div class="p-6 space-y-4">
                <div id="previewContent" class="prose dark:prose-invert max-w-none"></div>
            </div>
        </div>
    </div>

    <script>
        // Show progress dialog
        function showProgress(text, percentage, title = 'Saving') {
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
            const previewContainer = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const placeholder = document.getElementById('uploadPlaceholder');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                placeholder.classList.remove('hidden');
                previewContainer.classList.add('hidden');
                previewImg.removeAttribute('src');
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
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);
                document.getElementById('featured_image').files = dataTransfer.files;
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

        // Preview functionality
        document.getElementById('previewBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const category = document.querySelector('input[name="category"]:checked')?.value || 'Uncategorized';

            let previewHTML = `
                <h1 class="text-3xl font-bold mb-2">${title || 'Untitled Post'}</h1>
                <p class="text-sm text-gray-500 mb-4">Category: <strong>${category}</strong></p>
                <div class="text-gray-700 whitespace-pre-wrap">${content || 'No content yet...'}</div>
            `;

            document.getElementById('previewContent').innerHTML = previewHTML;
            document.getElementById('previewModal').classList.remove('hidden');
        });

        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
        }

        // Close preview on background click
        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePreview();
            }
        });
        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitter = e.submitter;
            const action = submitter?.name === 'action' ? submitter.value : (formData.get('action') || 'draft');
            const isPublish = action === 'publish';

            if (submitter?.name === 'action') {
                formData.set('action', action);
            }

            showProgress('Validating content...', 10, isPublish ? 'Publishing' : 'Saving Draft');

            setTimeout(() => {
                showProgress('Processing images...', 30, isPublish ? 'Publishing' : 'Saving Draft');
            }, 300);

            setTimeout(() => {
                showProgress('Compiling post...', 60, isPublish ? 'Publishing' : 'Saving Draft');
            }, 700);

            setTimeout(() => {
                showProgress('Finalizing...', 85, isPublish ? 'Publishing' : 'Saving Draft');

                fetch('{{ route('blog.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    showProgress('Complete!', 100, isPublish ? 'Publishing' : 'Saving Draft');
                    setTimeout(() => {
                        hideProgress();
                        if (data.success) {
                            const successDiv = document.createElement('div');
                            successDiv.className = 'fixed top-20 right-6 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                            successDiv.textContent = data.message;
                            document.body.appendChild(successDiv);

                            setTimeout(() => {
                                window.location.href = data.redirect || '{{ route('dashboard') }}';
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
