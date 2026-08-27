export function resolveImageUrl(path?: string | null): string | null {
    if (!path) {
        return null
    }

    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
        return path
    }

    return `/storage/${path}`
}
