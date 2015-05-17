# Useful commands

```
# Change tip commit of a branch
git branch -f branch-name new-tip-commit
```

Rebase with squashing, discarding all the messages but one which
can be rewritten. In the editor, change 'pick' with 'f' (fixup) and the first one with 'r' (reword). Save and a new editor will ask for the unique commit message.
```
git checkout topic-branch
git rebase -i main-branch

# After finishing, force push the rebased branch if needed
git push origin topic-branch -f
```
