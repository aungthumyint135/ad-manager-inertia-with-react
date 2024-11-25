import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link, usePage } from '@inertiajs/react';
import { PropsWithChildren, ReactNode, useState } from 'react';
import {SidebarProvider, SidebarTrigger} from "@/Components/ui/sidebar";
import { AppSidebar } from "@/Components/ui/app-sidebar"

export default function Authenticated({
    header,
    children,
}: PropsWithChildren<{ header?: ReactNode }>) {
    const user = usePage().props.auth.user;

    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="min-h-screen bg-gray-100">

            <SidebarProvider>
                <AppSidebar/>
                <main className="w-[calc(100%+8rem)]">
                    <SidebarTrigger/>
                    {children}
                </main>
            </SidebarProvider>

        </div>

    );
}
