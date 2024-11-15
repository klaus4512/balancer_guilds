import { Link } from '@inertiajs/react'

export default function ButtonLink({ href, className = '', children, disabled = false, ...props }) {
    if (disabled) {
        return (
            <button
                {...props}
                className={
                    `inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 bg-gray-400 text-gray-700 cursor-not-allowed ` +
                    className
                }
            >
                {children}
            </button>
        );
    }

    return (
        <Link
            href={href}
            {...props}
            className={
                `inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 ` +
                className
            }
        >
            {children}
        </Link>
    );
}
