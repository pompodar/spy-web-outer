import { useState } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';

export default function Guest({ children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    return (
        <div className="w-screentext-brightyellow min-h-screen bg-gradient-to-r from-brightpurple to-darkpurple flex flex-col align-center sm:pt-0 bg-gray-100">
            <nav className="lg:min-w-96 w-full lg:mt-8 lg:max-w-2xl max-w-screen-xl min-w-80 lg:mx-auto bg-brightpurple text-brightyellow border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex">
                            <div className="shrink-0 flex items-center">
                                <Link href="/">
                                    <img className="w-12 rounded-full" src="android-chrome-512x512.png" alt="Logo" />
                                </Link>
                            </div>
                
                        </div>

                        <div className="flex items-center ms-6">
                            <div className="ms-3 relative">
                            <Link
                                href={route('login')}
                                className="rounded-md px-3 py-2 text-brightyellow ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>
                            <Link
                                href={route('register')}
                                className="rounded-md px-3 py-2 text-brightyellow ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                            </div>
                        </div>

                      
                    </div>
                </div>
            </nav>


            <div className="w-full max-w-screen-sm lg:min-w-96 mx-auto lg:max-w-2xl max-w-full text-left bg-transparent sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg flex flex-col justify-center items-center">
                {children}
            </div>
        </div>
    );
}
