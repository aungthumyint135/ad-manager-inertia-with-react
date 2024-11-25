import { Config } from 'ziggy-js';

export interface User {
    id: number;
    uuid: string;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface Agency {
    id: number;
    uuid: string;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}
export interface RegisterData {
    name: string;
    email: string;
    network_code: string;
    agency_name: string;
    password:string;
    password_confirmation:string
}

export interface Publisher {
    id: number;
    uuid: string;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}

export interface Advertiser {
    id: number;
    uuid: string;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}

export type PaginatedData<T> = {
    data: T[];
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };

    meta: {
        current_page: number;
        from: number;
        last_page: number;
        path: string;
        per_page: number;
        to: number;
        total: number;

        links: {
            url: null | string;
            label: string;
            active: boolean;
        }[];
    };

};

// export type PageProps<
//     T extends Record<string, unknown> = Record<string, unknown>,
// > = T & {
//     auth: {
//         user: User;
//         agency: Agency;
//     };
// };

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    flash: {
        success: string | null;
        error: string | null;
    };
    ziggy: Config & { location: string };
};
