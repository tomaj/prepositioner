# Documentation Versioning

This guide explains how the documentation versioning system works and how to archive documentation when releasing a new major version.

## How It Works

The documentation is versioned to support multiple major versions simultaneously:

- **Current version** (`4.x`) - Lives on the `master` branch, deployed to the root: `https://tomaj.github.io/prepositioner/`
- **Archived versions** - Live on `docs-archive/<major>.x` branches, deployed to subdirectories: `https://tomaj.github.io/prepositioner/<major>.x/`

::: tip Version Dropdown
Users can switch between versions using the version dropdown in the navigation bar.
:::

## Version Structure

```
Repository branches:
├── master                    → Current docs (4.x)
└── docs-archive/3.x         → Archived docs for version 3.x
└── docs-archive/2.x         → Archived docs for version 2.x

Deployed documentation:
├── /prepositioner/          → Latest (4.x)
├── /prepositioner/3.x/      → Archived 3.x docs
└── /prepositioner/2.x/      → Archived 2.x docs
```

## Archiving Documentation (For Maintainers)

When releasing a new major version (e.g., moving from 4.x to 5.0.0), follow these steps to archive the old documentation:

### Step 1: Create Archive Branch

Before releasing the new major version, create an archive branch from `master`:

```bash
# Ensure you're on master with the latest 4.x docs
git checkout master
git pull origin master

# Create archive branch for 4.x
git checkout -b docs-archive/4.x
git push origin docs-archive/4.x
```

### Step 2: Update Master for New Version

Switch back to master and update the documentation for the new major version:

```bash
git checkout master

# Update version in docs/.vitepress/config.mts
# Change: const currentVersion = '4.x'
# To:     const currentVersion = '5.x'

# Add archived version to versions array:
const versions = [
  { text: 'Latest (5.x)', link: '/prepositioner/' },
  { text: '4.x', link: '/prepositioner/4.x/' }
]

# Commit the changes
git add docs/.vitepress/config.mts
git commit -m "docs: update to version 5.x"
git push origin master
```

### Step 3: Verify Deployment

After pushing, the GitHub Actions workflow will automatically:

1. Build the current docs (5.x) from `master` → deployed to `/prepositioner/`
2. Build archived docs (4.x) from `docs-archive/4.x` → deployed to `/prepositioner/4.x/`
3. Combine both into a single deployment

Check the deployment at:
- Latest (5.x): https://tomaj.github.io/prepositioner/
- Archived (4.x): https://tomaj.github.io/prepositioner/4.x/

::: warning Important
Do not delete archived branches. They are needed for the deployment workflow to build all versions.
:::

## Workflow Details

The documentation deployment workflow (`.github/workflows/docs.yml`) automatically:

- Triggers on pushes to `master` or any `docs-archive/*` branch
- Builds the current version from `master` with `base: '/prepositioner/'`
- Discovers and builds all `docs-archive/<major>.x` branches with `base: '/prepositioner/<major>.x/'`
- Merges all builds into a single Pages artifact
- Deploys everything to GitHub Pages

::: tip No Archives Yet?
If no `docs-archive/*` branches exist, the workflow works normally and deploys only the current version.
:::

## Updating Archived Documentation

To fix documentation bugs in an archived version:

```bash
# Checkout the archive branch
git checkout docs-archive/4.x

# Make your changes
# ... edit documentation files ...

# Commit and push
git add .
git commit -m "docs(4.x): fix typo in examples"
git push origin docs-archive/4.x
```

The workflow will automatically rebuild and redeploy all versions.

## Version Configuration

The version dropdown is configured in `docs/.vitepress/config.mts`:

```typescript
// Version configuration
const currentVersion = '4.x'
const versions = [
  { text: `Latest (${currentVersion})`, link: '/prepositioner/' },
  // Add archived versions here:
  // { text: '3.x', link: '/prepositioner/3.x/' }
]
```

## Best Practices

::: tip When to Archive
- Archive documentation when releasing a **new major version** (e.g., 4.0.0 → 5.0.0)
- Do not archive for minor or patch releases (e.g., 4.1.0, 4.0.1)
- Keep at least 2-3 major versions available
:::

::: warning Maintenance
- Archived versions should remain mostly unchanged
- Only apply critical bug fixes or security-related updates to archived docs
- Major documentation improvements should focus on the current version
:::

## Troubleshooting

### Archive Branch Not Building

If an archived version isn't appearing:

1. Check the branch name follows the pattern: `docs-archive/<major>.x`
2. Verify the branch contains a valid `docs/` directory
3. Check GitHub Actions logs for build errors
4. Ensure `docs/package.json` and `docs/package-lock.json` exist in the archive branch

### Version Dropdown Not Showing

If the version dropdown doesn't appear:

1. Verify `docs/.vitepress/config.mts` has the `versions` array populated
2. Check that `currentVersion` is set correctly
3. Rebuild the documentation locally: `npm run docs:build`

### Links Between Versions

::: warning
Links between different versions of the documentation should always be absolute URLs, not relative paths, to ensure they work correctly across all deployed versions.
:::
