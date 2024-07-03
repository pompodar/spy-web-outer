import { useEffect } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { signInWithGoogle } from "../config/firebase";

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('login'));
    };

    const submitWithGoogle = async (e) => {
        e.preventDefault();
        try {
            signInWithGoogle();
        } catch (error) {
            console.error("Google sign-in failed:", error);
        }
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="flex flex-col lg:flex-row gap-8">
                <form onSubmit={submitWithGoogle}>
                    <div>
                        <p className="text-brightyellow mb-2">Log in with Gmail</p>
                        <PrimaryButton className="lg:ms-4 text-brightyellow" disabled={processing}>
                            Log in
                        </PrimaryButton>
                    </div>
                </form>

                <form onSubmit={submit}>
                    <div>
                        <p className="text-brightyellow mb-2">Or with mail</p>

                        <InputLabel className="text-brightyellow" htmlFor="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full bg-gradient-to-r from-brightpurple to-darkpurple"
                            autoComplete="username"
                            isFocused={true}
                            onChange={(e) => setData('email', e.target.value)}
                        />

                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel className="text-brightyellow" htmlFor="password" value="Password" />

                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full bg-gradient-to-r from-brightpurple to-darkpurple"
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                        />

                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="block mt-4">
                        <label className="flex items-center">
                            <Checkbox
                                name="remember"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                            />
                            <span className="text-brightyellow ms-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        {/* {canResetPassword && (
                            <Link
                                href={route('password.request')}
                                className="text-brightyellow underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Forgot your password?
                            </Link>
                        )} */}

                        <PrimaryButton className="ms-4 text-brightyellow" disabled={processing}>
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </GuestLayout>
    );
}
