#!/bin/bash

# Base directory for the pages
BASE_DIR="resources/js/Pages/App"

# Array of directories and files
declare -A pages=(
    ["Schedule"]="Index.vue Create.vue Edit.vue Show.vue"
    ["Inventory"]="Index.vue Create.vue Edit.vue Show.vue"
    ["Report"]="Index.vue Create.vue Edit.vue Show.vue"
    ["Grade"]="Index.vue Create.vue"
)

# Function to create directories and files
create_pages() {
    for folder in "${!pages[@]}"; do
        # Create directory if it doesn't exist
        mkdir -p "$BASE_DIR/$folder"
        
        # Create each file in the directory
        for file in ${pages[$folder]}; do
            file_path="$BASE_DIR/$folder/$file"
            if [ ! -f "$file_path" ]; then
                touch "$file_path"
                echo "<template>
    <div>
        <!-- $file for $folder -->
    </div>
</template>

<script>
export default {
    name: '${folder}${file%.vue}'
}
</script>

<style scoped>
                </style>" > "$file_path"
            fi
        done
    done
}

# Run the function
create_pages

echo "Folders and files created successfully in $BASE_DIR"
