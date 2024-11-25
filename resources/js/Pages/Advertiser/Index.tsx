import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import { Advertiser, PaginatedData} from '@/types';
import { DataTable } from '@/Components/DataTable';
import {columns} from './Columns';


export default function Index() {
    const { advertisers } = usePage<{ publishers: PaginatedData<Advertiser> }>().props;
    return (
        <AuthenticatedLayout>
            <Head title="Agency" />

            <div className="m-5 p-12 border rounded bg-gray-100">
                <div className={"pb-5 text-2xl font-bold"}>
                    Agencies
                </div>
                <DataTable columns={columns} data={advertisers} />
            </div>

        </AuthenticatedLayout>
    );
}
