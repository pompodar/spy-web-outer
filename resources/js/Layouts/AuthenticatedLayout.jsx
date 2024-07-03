import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link } from '@inertiajs/react';
import { auth as firebaseAuth } from '../Pages/config/firebase';
import { onAuthStateChanged, getAuth, signOut } from 'firebase/auth';
import React, { useState, useEffect } from 'react';

export default function Authenticated({ user, header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    const [userGoogle, setGoogleUser] = useState(null);

    useEffect(() => {
        const unsubscribe = onAuthStateChanged(firebaseAuth, (currentUser) => {
            setGoogleUser(currentUser);

            if (currentUser) {
                console.log("User set on auth state changed in Authenticated layout", currentUser);
            } else {
                console.log("User not on on auth state changed in Authenticated layout", currentUser);
            }
        });

        // Cleanup subscription on unmount
        return () => unsubscribe();
    }, []);

    const handleLogout = () => {
        const auth = getAuth();
        signOut(auth).then(() => {
            console.log("User signed-out successfully.");
        }).catch((error) => {
            console.log("Error when signing-out");
        });
    };

    return (
        <div className="max-w-screen-xl mx-auto bg-gradient-to-r from-brightpurple shadow-lg">
            <nav className="bg-brightpurple text-brightyellow border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex">
                            <div className="shrink-0 flex items-center">
                                <Link href="/">
                                    <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <div className="text-brightyellow hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink className="text-brightyellow" href={route('welcome')} active={route().current('welcome')}>
                                    Game Lobby
                                </NavLink>
                            </div>
                        </div>

                        <div className="hidden sm:flex sm:items-center sm:ms-6">
                            <div className="ms-3 relative">
                                <Dropdown className="bg-brightpurple text-brightyellow">
                                    <Dropdown.Trigger>
                                        <span className="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                className="bg-transparent inline-flex items-center px-3 py-2 border border-transparent text-sm text-brightyellow leading-4 font-medium rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {user?.name || userGoogle?.displayName}

                                                <svg
                                                    className="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fillRule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clipRule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </Dropdown.Trigger>

                                    <Dropdown.Content>
                                        {/* <Dropdown.Link className="bg-brightpurple text-brightyellow" href={route('profile.edit')}>Profile</Dropdown.Link> */}
                                        { userGoogle && (
                                            <Dropdown.Link className="bg-brightpurple text-brightyellow" onClick={() => handleLogout(userGoogle)}>
                                                Log Out
                                            </Dropdown.Link>
                                            ) 
                                        }

                                        {!userGoogle && (
                                            <Dropdown.Link className="bg-brightpurple text-brightyellow" href={route('logout')} method="post" as="button">
                                                Log Out
                                            </Dropdown.Link>
                                            )
                                        }
                
                                    </Dropdown.Content>
                                </Dropdown>
                            </div>
                        </div>

                        <div className="-me-2 flex items-center sm:hidden">
                            <button
                                onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 focus:outline-none transition duration-150 ease-in-out"
                            >
                                <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
                    <div className="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink href={route('welcome')} active={route().current('welcome')}>
                            Game Lobby
                        </ResponsiveNavLink>
                    </div>

                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="px-4">
                            <div className="font-medium text-base text-yellowbright">{user?.name}</div>
                            <div className="font-medium text-sm text-yellowbright">{user?.email}</div>
                        </div>

                        <div className="mt-3 space-y-1">
                            {/* <ResponsiveNavLink href={route('profile.edit')}>Profile</ResponsiveNavLink> */}
                            { userGoogle && (
                                <ResponsiveNavLink onClick={() => handleLogout(userGoogle)} as="button">
                                    Log Out
                                </ResponsiveNavLink>
                                ) 
                            }

                            {!userGoogle && (
                                <ResponsiveNavLink method="post" href={route('logout')} as="button">
                                Log Out
                            </ResponsiveNavLink>
                                )
                            }
                        </div>
                    </div>
                </div>
            </nav>

            {header && (
                <header className="bg-white shadow">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{header}</div>
                </header>
            )}

            <main>{children}</main>
        </div>
    );
}
