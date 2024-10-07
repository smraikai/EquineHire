<!-- Quill Editor -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
<script>
    var Delta = Quill.import('delta');
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#bio_editor', {
            theme: 'snow',
            placeholder: '{{ $placeholder ?? 'Enter your bio here' }}',
            modules: {
                toolbar: [
                    [{
                        header: [2, 3, false]
                    }],
                    ['bold', 'italic'],
                    [{
                        list: 'bullet'
                    }],
                    ['clean'],
                ],
                clipboard: {
                    matchVisual: false,
                    matchers: [
                        ['img', function() {
                            return new Delta();
                        }],
                        ['a', function() {
                            return new Delta();
                        }],
                        ['table', function() {
                            return new Delta();
                        }],
                        ['header', 'blockquote', 'code-block', function(node, delta) {
                            var ops = [];
                            delta.ops.forEach(op => {
                                if (op.insert && typeof op.insert === 'string') {
                                    ops.push({
                                        insert: op.insert
                                    });
                                }
                            });
                            return new Delta(ops);
                        }]
                    ]
                }
            }
        });

        // Initialize Quill with existing bio
        var bioContent = document.getElementById('bio').value;
        if (bioContent) {
            quill.root.innerHTML = bioContent;
        }

        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            // Before form submission, update hidden input with Quill's content
            var bio = document.getElementById('bio');
            bio.value = quill.root.innerHTML;
        });

        // Keep bio text updated
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("bio").value = quill.root.innerHTML;
        });

        quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
            const ops = delta.ops.map((op) => ({
                insert: op.insert
            }));
            return new Delta(ops)
        })

        // Make Quill globally accessible
        window.quill = quill;
    });
</script>
