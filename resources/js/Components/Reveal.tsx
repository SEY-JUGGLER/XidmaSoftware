import { useEffect, useRef, useState, type ReactNode } from 'react'

export default function Reveal({
    children,
    delay = 0,
    className = '',
}: {
    children: ReactNode
    delay?: number
    className?: string
}) {
    const ref = useRef<HTMLDivElement | null>(null)
    const [visible, setVisible] = useState(false)

    useEffect(() => {
        const node = ref.current
        if (!node) {
            return
        }

        if (typeof IntersectionObserver === 'undefined') {
            setVisible(true)
            return
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setVisible(true)
                    observer.unobserve(node)
                }
            },
            { threshold: 0.15, rootMargin: '0px 0px -40px 0px' },
        )

        observer.observe(node)

        return () => observer.disconnect()
    }, [])

    return (
        <div
            ref={ref}
            className={`${visible ? 'animate-fade-up' : 'opacity-0'} ${className}`}
            style={visible ? { animationDelay: `${delay}ms` } : undefined}
        >
            {children}
        </div>
    )
}
