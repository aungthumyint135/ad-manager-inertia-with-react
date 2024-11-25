import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, useForm, usePage} from '@inertiajs/react';
import { FormEventHandler } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {PaginatedData, User} from "@/types";

import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import {put} from "axios";

export default function CreateUser({roles, user}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: user?.name ?? '',
        email: user?.email ?? '',
        password: '',
        password_confirmation: '',
        type: '',
        _method: user? 'put' : 'post'
    });

    const selectChange = (value: string) => {
        setData('type', value);
    }

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        if(user) {
            post(route('users.update', user?.uuid));
        }else {
            post(route('users.store'), {
                onFinish: () => reset('password', 'password_confirmation'),
            });
        }

    };

    return (
        <AuthenticatedLayout>
            <Head title={ user ? 'Edit' : 'Create'} />

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
                    <InputLabel htmlFor="type" value="Type"/>

                    <Select name="type" onValueChange={selectChange}
                            value={user?.roles[0]?.name}
                    >
                        <SelectTrigger className="w-[180px]">
                            <SelectValue placeholder="Select a user type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Types</SelectLabel>
                                {roles.map((item) =>
                                    <SelectItem value={item.type} key={item.type}>{item.type}</SelectItem>
                                )}

                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <InputError message={errors.type} className="mt-2"/>
                </div>

                { user ? '' :
                    <>
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
                    </>
}
                <div className="mt-4 flex items-center justify-end">


                    <PrimaryButton className="ms-4" disabled={processing}>
                        {user ? 'Update' : 'Create'}
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
