import { ColumnDef } from "@tanstack/react-table";
import {User} from "@/types";
import { MoreHorizontal } from "lucide-react"

import { Button } from "@/components/ui/button"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import { DeleteModal } from "@/Components/DeleteModal";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog"
import {router} from "@inertiajs/react";

export const columns: ColumnDef<User>[] = [
  {
    accessorKey: "name",
    header: "Name",
  },
  {
    accessorKey: "is_active",
    header: "Status",
  },
  {
    accessorKey: "created_at",
    header: "Created At",
  },
  {
    accessorKey: "roles[0].name",
    header: "Type",
      cell: ({ row }) => (
          <span>{row.original?.roles[0]?.name}</span>
      ),
  },
  {
    accessorKey: "actions",
    header: "",
    cell: ({ row }) => {
      const user = row.original

      return (
          <Dialog>
              <DropdownMenu>
                  <DropdownMenuTrigger>
                      <strong>Actions</strong>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent>
                      <DropdownMenuItem>
                          <DialogTrigger>
                              Delete
                          </DialogTrigger>

                      </DropdownMenuItem>
                      <DropdownMenuItem
                          onClick={() => location.replace(`/users/${user.uuid}/edit`)}
                      >
                          Edit
                      </DropdownMenuItem>
                  </DropdownMenuContent>
              </DropdownMenu>
              <DialogContent>
                  <DialogHeader>
                      <DialogTitle>Are you sure?</DialogTitle>
                      <DialogDescription>
                          Do you want to delete the entry? Deleting this entry cannot be
                          undone.
                      </DialogDescription>
                  </DialogHeader>
                  <DialogFooter>
                      <DialogClose asChild>
                          <Button variant="outline">Cancel</Button>
                      </DialogClose>
                      <DialogTrigger className={'bg-black px-4 rounded text-white'} onClick={() =>
                          router.delete(route('users.destroy',user.uuid))
                      }>
                          Delete
                      </DialogTrigger>
                  </DialogFooter>
              </DialogContent>
          </Dialog>

      )
    }
  }

]
