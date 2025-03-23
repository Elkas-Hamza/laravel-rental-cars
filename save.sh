#!/bin/bash

# Check if a commit message was provided as an argument
if [ -z "$1" ]; then
  # If no commit message is provided, use the default message with the current date and time
  commit_message="Change something at $(date '+%Y-%m-%d %H:%M:%S')"
else
  # If a commit message is provided, use that message
  commit_message="$1"
fi

# Add all changes to the staging area
git add .

# Commit the changes with the chosen commit message
git commit -m "$commit_message"

# Push the changes to the remote repository
git push

echo "Changes pushed with commit message: '$commit_message'"
