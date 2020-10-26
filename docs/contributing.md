# Contributing
This project adopts the following guidelines:

* [Git flow][]
* [AngularJS commit message guidelines][]

[Git flow]: #git-flow
[AngularJS commit message guidelines]: https://github.com/angular/angular.js/blob/master/CONTRIBUTING.md#-git-commit-guidelines

Looking for some work? Great! Pick an [issue](#work-on-an-issue) - **and assign, comment and/or slack it so everyone's aware**.

Fixed a bug, done some refactoring or wrote a new feature? Awesome! File a
[pull request](#pull-requests).

Spotted an bug or found something you can't otherwise fix? No worries! File an
[issue](#file-an-issue).


## Git flow

We use the principles from Git flow described [here][Git flow source] with a couple of small
additions: 

- we always merge changes through GitHub pull requests, that makes it easier
to keep a conversation about possible issues to solve before merging.
- we require the pull request to be reviewed by somebody
before merging. To show that we have reviewed a pull request we usually add a
comment saying so, a simple "LGTM" or ":+1:" are enough for that.
- after getting the review and approval, it's the pull request author responsibility to
merge the code, i.e. push the big fat green button in GitHub. The author knows
best if the pull request can be merged immediately or if there is anything else
to do before that (like creating a view on the database). 
- do not forget to delete the merged branch from GitHub!

[Git flow source]: http://nvie.com/posts/a-successful-git-branching-model/

## File an issue

1. Search the [GitHub issue tracker][] to see if the issue has already been
   reported

2. Update your local `develop` to check if the issue has already been fixed

Otherwise, confirm the issue is reproducible, and file a [new issue][] with
[as much detail as possible](Bug reports), provide screenshots if that can help understand
the problem. A good bug report shouldn't leave others needing to chase you up
for more information. If the bug and/or the reproduction steps can't be easily
explained with a few words, it can be hepful to create a [reduced test case][].

[Bug reports]: https://github.com/necolas/issue-guidelines/blob/master/CONTRIBUTING.md#bug-reports
[GitHub issue tracker]: https://github.com/CJIDNG/POD
[reduced test case]: http://css-tricks.com/reduced-test-cases
[new issue]: https://github.com/CJIDNG/POD

## Work on an issue

Ready to work on an issue? The best is to go to our [Github Projects][] board and find an issue there.

Now that you have picked your issue you don't want anybody else to start working on
it at the same time, so don't forget to assign it to yourself and move it to "In Progress".

[Github Projects]: https://github.com/CJIDNG/POD/projects/

## Pull requests

We use the [Git flow][] branching strategy:

1. Clone the project

    ```bash
    git clone CJIDNG/POD
    cd husk
    ```

2. Create a topic (bug/feature/refactor) branch off `develop`:

    ```bash
    git checkout --track origin/develop
    git checkout -b my-feature
    ```

3. Write and commit some code

    * Group logical steps ([Git's interactive rebase][] can help)
    * Make sure to maintain the project's coding style
    * **Write an appropriate test case**
    * Write a short (50 chars or less) commit summary and a detailed body,
    following [AngularJS commit message guidelines][]. See below commit messages

[Standard]: http://standardjs.com/rules.html
[Git's interactive rebase]: https://help.github.com/articles/about-git-rebase/

4. When your topic is finished, make sure it's up-to-date

    ```bash
    git pull --rebase origin develop
    ```

5. Push your branch to the remote

    ```bash
    git push origin my-feature
    ```

7. Assign a member of [the dev team][] as a reviewer. Someone who has recently worked on related parts of the code often makes a good reviewer. Use GitHub's suggested reviewer if in doubt. Assign the same person in the "assignees" list. This is to provide clarification on who's currently reviewing what.

8. (As a reviewer) refer back to the parent ticket to ensure the pull request meets its acceptance criteria. Initiate constructive discussion if the pull request is not quite ready to merge. Assign the pull request back to the author when ready or if follow up is needed.

9. (As the author) work with the reviewer until the pull request is ready to merge. Note, this may mean several cycles of reviews/amendments are needed, but try not to become discouraged 😄. Once the pull request is ready (reviewed, tests pass, all [status checks][] are green), it is your responsibility to merge; you'll be most familiar with the code and how it integrates with the current state of the project. Merge away when ready 🎉.

## Branch Names

In all Repos, we use the following convention for creating branches: 
`fix/<short-description>` for branches that contain fixes, and `feat/<short-description>`
for feature branches.

we branch off `master` and merge back to `master`.


## Commit Messages

Qe use semantic release to trigger releases. 

- https://github.com/semantic-release/semantic-release#commit-message-format
- https://github.com/conventional-changelog/conventional-changelog/tree/master/packages/conventional-changelog-angular#type

so only `fix:`, `feat:` and `perf:` will trigger a release. `refactor:`, `docs:`, `test:`, etc, will not cause a release. `revert` is new but our semantic release versions might not be updated to support it, so when in doubt use `fix` for a revert.

## WIP: Reviewing Code/Getting code reviewed
- We use the github code review system, even if you have discussions on slack, try to put some things from it in here so we can find the arguments later.
- Reviewing code and being reviewed takes time and requires patience. For a 300 lines, allow at least [60 minutes for the review](https://smartbear.com/learn/code-review/best-practices-for-peer-code-review/). 
- [General tips about tone and language can be found here](https://github.com/thoughtbot/guides/tree/master/code-review). Be kind :)
- Ask questions rather than stating demands
- The reviewer should run the code, (not running it is only tiny changes and test changes, where travis run it)
- As a reviewer, make sure you understand the change, and that you can do the interactions that are expected. If not, work with the committer until you can (this can be related to setup issues, not understanding the PR, etc)
- Look for conventions around the code, is the additions following these conventions?
- Are the conventions in the surrounding code up-to-date with what we consider good practice? If you are unsure you can pull in further people here
- Is the changes covered by tests? If not, what could be a reasonable effort for adding some tests around the changes?
- If the PR generates a more fundamental architecture discussion - maybe the review is not the right place to have it?