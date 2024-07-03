import { Link } from '@inertiajs/react';

export default function ResponsiveNavLink({ active = false, className = '', children, ...props }) {
    return (
        <Link
            {...props}
            className={`w-full flex items-start ps-3 pe-4 py-2 border-l-4 ${
                active
                    ? 'border-indigo-400 text-yellowbright focus:text-indigo-800 hover:text-red-500'
                    : 'border-transparent text-yellowbright hover:text-red-500'
            } text-base font-medium focus:outline-none transition duration-150 ease-in-out ${className}`}
        >
            {children}
        </Link>
    );
}
