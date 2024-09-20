<script>
    function setupDropdown(endpoint, inputId, dropdownId, tagsId, selectedInputId, itemKeyName) {
        fetch(`/${endpoint}`)
            .then(response => response.json())
            .then(items => {
                items.sort((a, b) => {
                    if (a.name === 'Other') return 1;
                    if (b.name === 'Other') return -1;
                    return a.name.localeCompare(b.name);
                });
                const inputElement = document.getElementById(inputId);
                const dropdownElement = document.getElementById(dropdownId);
                const tagsElement = document.getElementById(tagsId);
                const selectedInputElement = document.getElementById(selectedInputId);

                const itemMap = new Map();
                items.forEach(item => {
                    itemMap.set(item.id, item);
                    if (!item.parent_id) {
                        item.subitems = [];
                    } else {
                        const parent = itemMap.get(item.parent_id) || {
                            subitems: []
                        };
                        parent.subitems.push(item);
                        itemMap.set(item.parent_id, parent);
                    }
                });

                const selectedItems = new Set(
                    selectedInputElement.value.split(',')
                    .filter(id => id.trim() !== '')
                    .map(Number)
                );

                const updateSelectedItems = () => {
                    selectedInputElement.value = Array.from(selectedItems).join(',');
                };

                const createTagElement = (item) => {
                    const tagElement = document.createElement('span');
                    tagElement.classList.add('inline-flex', 'items-center', 'px-2', 'py-1', 'mb-2', 'mr-2',
                        'text-sm', 'font-medium', 'text-gray-800', 'bg-gray-100', 'rounded-sm');
                    tagElement.dataset[itemKeyName + 'Id'] = item.id;
                    if (item.parent_id) {
                        tagElement.style.marginLeft = '20px';
                    }
                    tagElement.textContent = item.name + ' ';

                    const removeButton = document.createElement('button');
                    removeButton.textContent = '×';
                    removeButton.classList.add('ml-2', 'text-gray-500', 'hover:text-gray-600',
                        'focus:outline-none', 'remove-' + itemKeyName);
                    removeButton.type = 'button';

                    tagElement.appendChild(removeButton);
                    return tagElement;
                };

                const populateDropdown = (items) => {
                    dropdownElement.innerHTML = '';
                    items.forEach(item => {
                        if (!selectedItems.has(item.id)) {
                            const dropdownItem = document.createElement('div');
                            dropdownItem.textContent = item.name;
                            dropdownItem.className =
                                'px-4 py-2 text-gray-800 hover:bg-gray-100 cursor-pointer';
                            dropdownItem.style.paddingLeft = `${item.parent_id ? 20 : 10}px`;
                            dropdownItem.onclick = () => {
                                const tagElement = createTagElement(item);
                                tagsElement.appendChild(tagElement);
                                selectedItems.add(item.id);
                                updateSelectedItems();
                                populateDropdown(items); // Refresh the dropdown to reflect changes

                                // Clear the category error message
                                const categoryError = document.getElementById('categoryError');
                                categoryError.textContent = '';
                            };
                            dropdownElement.appendChild(dropdownItem);
                        }
                    });
                };

                tagsElement.addEventListener('click', (event) => {
                    if (event.target.classList.contains('remove-' + itemKeyName)) {
                        const tagElement = event.target.closest('span');
                        const itemId = Number(tagElement.dataset[itemKeyName + 'Id']);
                        selectedItems.delete(itemId);
                        tagElement.remove();
                        updateSelectedItems();
                    }
                });

                inputElement.addEventListener('input', () => {
                    // Clear the category error message
                    const categoryError = document.getElementById('categoryError');
                    categoryError.textContent = '';

                    const searchTerm = inputElement.value.trim().toLowerCase();
                    const filteredItems = items.filter(item => item.name.toLowerCase().includes(
                        searchTerm));
                    populateDropdown(filteredItems);
                });

                document.addEventListener('click', (e) => {
                    if (!inputElement.contains(e.target) && !dropdownElement.contains(e.target)) {
                        dropdownElement.innerHTML = '';
                    }
                });

                dropdownElement.style.display = 'none';
                inputElement.addEventListener('click', () => {
                    dropdownElement.style.display = 'block';
                    populateDropdown(items);
                });
            })
            .catch(error => console.error(`Error fetching ${endpoint}:`, error));
    }

    // Setup dropdowns for categories and disciplines
    setupDropdown('categories', 'category-input', 'category-dropdown', 'category-tags', 'selected-categories',
        'category');
    setupDropdown('disciplines', 'discipline-input', 'discipline-dropdown', 'discipline-tags', 'selected-disciplines',
        'discipline');
</script>
