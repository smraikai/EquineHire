<!-- Quill Editor -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
<script>
    var Delta = Quill.import('delta');
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#quill_editor', {
            theme: 'snow',
            placeholder: 'Enter your business description', // Add the placeholder text here
            modules: {
                toolbar: [
                    [{
                        header: [2, 3, false]
                    }],
                    ['bold', 'italic', ],
                    [{
                        list: 'bullet'
                    }],
                    ['clean'], // remove formatting button
                ],
                clipboard: {
                    matchVisual: false,
                    matchers: [
                        ['img', function() {
                            return new Delta();
                        }], // Blocks images
                        ['a', function() {
                            return new Delta();
                        }], // Blocks hyperlinks
                        ['table', function() {
                            return new Delta();
                        }], // Blocks tables
                        ['header', 'blockquote', 'code-block', function(node, delta) {
                            // Remove these elements, flatten their content as plain text
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
        // Initialize Quill with existing description
        var descriptionContent = document.getElementById('description').value;
        if (descriptionContent) {
            quill.root.innerHTML = descriptionContent;
        }
        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            // Before form submission, update hidden input with Quill's content
            var description = document.getElementById('description');
            description.value = quill.root.innerHTML;
        });

        // Keep description text updated
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("description").value = quill.root.innerHTML;
        });

        //
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
