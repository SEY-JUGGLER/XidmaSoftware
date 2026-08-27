export type IconName =
    | 'computer-desktop'
    | 'bolt'
    | 'chart-bar'
    | 'lifebuoy'
    | 'cog'
    | 'users'
    | 'sparkles'
    | 'arrow-right'
    | 'check-circle'
    | 'chat'
    | 'mail'
    | 'phone'
    | 'map-pin'
    | 'menu'
    | 'close'
    | 'chevron-down'
    | 'target'
    | 'rocket'
    | 'shield-check'

export default function Icon({ name, className = 'size-6' }: { name: IconName; className?: string }) {
    const common = {
        className,
        fill: 'none' as const,
        viewBox: '0 0 24 24',
        stroke: 'currentColor',
        strokeWidth: 1.6,
        strokeLinecap: 'round' as const,
        strokeLinejoin: 'round' as const,
        'aria-hidden': true,
    }

    switch (name) {
        case 'computer-desktop':
            return (
                <svg {...common}>
                    <rect x="3" y="4.5" width="18" height="12" rx="1.5" />
                    <path d="M9 20h6M12 16.5V20" />
                </svg>
            )
        case 'bolt':
            return (
                <svg {...common}>
                    <path strokeLinejoin="round" d="M13 3 5 13.5h5.5L11 21l8-11h-5.5L13 3Z" />
                </svg>
            )
        case 'chart-bar':
            return (
                <svg {...common}>
                    <path d="M4 20V10M12 20V4M20 20v-7" />
                    <path d="M4 20h16" />
                </svg>
            )
        case 'lifebuoy':
            return (
                <svg {...common}>
                    <circle cx="12" cy="12" r="8.5" />
                    <circle cx="12" cy="12" r="3.5" />
                    <path d="m6.3 6.3 3.3 3.3M17.7 6.3l-3.3 3.3M6.3 17.7l3.3-3.3M17.7 17.7l-3.3-3.3" />
                </svg>
            )
        case 'cog':
            return (
                <svg {...common}>
                    <circle cx="12" cy="12" r="3.2" />
                    <path d="M12 3.5v2.3M12 18.2v2.3M20.5 12h-2.3M5.8 12H3.5M17.8 6.2l-1.6 1.6M7.8 16.2l-1.6 1.6M17.8 17.8l-1.6-1.6M7.8 7.8 6.2 6.2" />
                </svg>
            )
        case 'users':
            return (
                <svg {...common}>
                    <circle cx="9" cy="8.5" r="3" />
                    <path d="M3.5 19c.7-3 3-4.8 5.5-4.8s4.8 1.8 5.5 4.8" />
                    <circle cx="17" cy="9.5" r="2.3" />
                    <path d="M16 14.4c2 .3 3.7 1.9 4.2 4.2" />
                </svg>
            )
        case 'sparkles':
            return (
                <svg {...common}>
                    <path d="M11 3v4M11 14v4M4 9h4M15 9h4" />
                    <path d="M11 3c0 3.3 2.7 6 6 6-3.3 0-6 2.7-6 6 0-3.3-2.7-6-6-6 3.3 0 6-2.7 6-6Z" />
                </svg>
            )
        case 'arrow-right':
            return (
                <svg {...common}>
                    <path d="M4 12h16M14 6l6 6-6 6" />
                </svg>
            )
        case 'check-circle':
            return (
                <svg {...common}>
                    <circle cx="12" cy="12" r="9" />
                    <path d="m8.3 12.3 2.5 2.5 5-5.2" />
                </svg>
            )
        case 'chat':
            return (
                <svg {...common}>
                    <path d="M4 5.5h16v10.5H9.5L5 20v-4H4Z" strokeLinejoin="round" />
                </svg>
            )
        case 'mail':
            return (
                <svg {...common}>
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="m4 6.5 8 6.5 8-6.5" />
                </svg>
            )
        case 'phone':
            return (
                <svg {...common}>
                    <path d="M5 4.5h3.2l1.3 4-2 1.6a11.5 11.5 0 0 0 5.4 5.4l1.6-2 4 1.3V18a1.5 1.5 0 0 1-1.6 1.5A15.5 15.5 0 0 1 3.5 6.1 1.5 1.5 0 0 1 5 4.5Z" strokeLinejoin="round" />
                </svg>
            )
        case 'map-pin':
            return (
                <svg {...common}>
                    <path d="M12 21s7-6.1 7-11.5a7 7 0 1 0-14 0C5 14.9 12 21 12 21Z" strokeLinejoin="round" />
                    <circle cx="12" cy="9.5" r="2.3" />
                </svg>
            )
        case 'menu':
            return (
                <svg {...common}>
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            )
        case 'close':
            return (
                <svg {...common}>
                    <path d="M6 6l12 12M18 6 6 18" />
                </svg>
            )
        case 'chevron-down':
            return (
                <svg {...common}>
                    <path d="m6 9 6 6 6-6" />
                </svg>
            )
        case 'target':
            return (
                <svg {...common}>
                    <circle cx="12" cy="12" r="8.5" />
                    <circle cx="12" cy="12" r="4.5" />
                    <circle cx="12" cy="12" r="0.8" fill="currentColor" />
                </svg>
            )
        case 'rocket':
            return (
                <svg {...common}>
                    <path d="M12 3c3 1.3 5 4.4 5 8.5 0 2-1 4-2 5l-1.5 3-1.5-3-1.5 3-1.5-3c-1-1-2-3-2-5C7 7.4 9 4.3 12 3Z" strokeLinejoin="round" />
                    <circle cx="12" cy="10.5" r="1.7" />
                </svg>
            )
        case 'shield-check':
            return (
                <svg {...common}>
                    <path d="M12 3.5 19 6v6c0 4.5-3 7.5-7 8.5-4-1-7-4-7-8.5V6l7-2.5Z" strokeLinejoin="round" />
                    <path d="m9 12 2.2 2.2L15.5 10" />
                </svg>
            )
        default:
            return null
    }
}
