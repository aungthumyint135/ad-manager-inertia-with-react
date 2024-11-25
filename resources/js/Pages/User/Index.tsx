import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, router} from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import {columns} from './Columns';
import {PaginatedData, User} from '@/types';
import pickBy from 'lodash/pickBy';
import { DataTable } from '@/Components/DataTable';
import {Input} from "@/Components/ui/input";
import {useCallback, useState} from "react";

import {usePrevious, useSearchParam} from 'react-use';

export default function Index() {
    const { users } = usePage<{ users: PaginatedData<User> }>().props;

    const params = useSearchParam('search');

    const [originParam, setOriginParam] = useState(params ?? '')

    const searchUsers = useCallback((e) => {
        setOriginParam(e.target.value)
        router.get(route(route().current()), {search: e.target.value },{
            replace: true,
            preserveState: true
        })
    }, [originParam]);

    return (
        <AuthenticatedLayout>
            <Head title="User" />

            <div className="m-5 p-12 border rounded bg-gray-100">
                <div className={"pb-5 text-2xl font-bold"}>
                    <strong>Users</strong>
                </div>

                <div className={'flex justify-end  p-3'}>

                    <div className={'w-1/5 mx-4'}>
                        <Input placeholder={'Search'}
                               onChange={searchUsers}
                               value={originParam}
                        ></Input>
                    </div>
                    <Link href={'/users/create'}
                          className={
                              "inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transitionduration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                          }
                    >Create</Link>
                </div>
                <DataTable columns={columns} data={users}/>
            </div>

        </AuthenticatedLayout>
    );
}
