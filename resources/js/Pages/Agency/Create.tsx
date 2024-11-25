import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';


export default function CreateAgency() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('agencies.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <AuthenticatedLayout>
            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="name" value="Name"/>

                    <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        isFocused={true}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                    />

                    <InputError message={errors.name} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email"/>

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        required
                    />

                    <InputError message={errors.email} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password"/>

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />

                    <InputError message={errors.password} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel
                        htmlFor="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) =>
                            setData('password_confirmation', e.target.value)
                        }
                        required
                    />

                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>

                <div className="mt-4 flex items-center justify-end">


                    <PrimaryButton className="ms-4" disabled={processing}>
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticatedLayout>
        // <AuthenticatedLayout>
        //     <Head title="Agency" />
        //
        //     <form onSubmit={submit}>
        //         <div>
        //             <InputLabel htmlFor="name" value="Name" />
        //
        //             <TextInput
        //                 id="name"
        //                 name="name"
        //                 value={data.name}
        //                 className="mt-1 block w-full"
        //                 autoComplete="name"
        //                 isFocused={true}
        //                 onChange={(e) => setData('name', e.target.value)}
        //                 required
        //             />
        //
        //             <InputError message={errors.name} className="mt-2" />
        //         </div>
        //
        //         <div className="mt-4">
        //             <InputLabel htmlFor="email" value="Email" />
        //
        //             <TextInput
        //                 id="email"
        //                 type="email"
        //                 name="email"
        //                 value={data.email}
        //                 className="mt-1 block w-full"
        //                 autoComplete="username"
        //                 onChange={(e) => setData('email', e.target.value)}
        //                 required
        //             />
        //
        //             <InputError message={errors.email} className="mt-2" />
        //         </div>
        //
        //         <div className="mt-4">
        //             <InputLabel htmlFor="password" value="Password" />
        //
        //             <TextInput
        //                 id="password"
        //                 type="password"
        //                 name="password"
        //                 value={data.password}
        //                 className="mt-1 block w-full"
        //                 autoComplete="new-password"
        //                 onChange={(e) => setData('password', e.target.value)}
        //                 required
        //             />
        //
        //             <InputError message={errors.password} className="mt-2" />
        //         </div>
        //
        //         <div className="mt-4">
        //             <InputLabel
        //                 htmlFor="password_confirmation"
        //                 value="Confirm Password"
        //             />
        //
        //             <TextInput
        //                 id="password_confirmation"
        //                 type="password"
        //                 name="password_confirmation"
        //                 value={data.password_confirmation}
        //                 className="mt-1 block w-full"
        //                 autoComplete="new-password"
        //                 onChange={(e) =>
        //                     setData('password_confirmation', e.target.value)
        //                 }
        //                 required
        //             />
        //
        //             <InputError
        //                 message={errors.password_confirmation}
        //                 className="mt-2"
        //             />
        //         </div>
        //
        //         <div className="mt-4 flex items-center justify-end">
        //
        //
        //             <PrimaryButton className="ms-4" disabled={processing}>
        //                 Create
        //             </PrimaryButton>
        //         </div>
        //     </form>
        //     </AuthenticatedLayout>
    );
}
