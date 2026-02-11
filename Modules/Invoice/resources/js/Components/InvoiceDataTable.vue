<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
    FlexRender,
    createColumnHelper,
    getCoreRowModel,
    getSortedRowModel,
    useVueTable,
    type SortingState,
} from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Input from '@/components/ui/input/Input.vue';
import StatusPill from './StatusPill.vue';

interface Client {
    id: number;
    name: string;
    email?: string | null;
}

interface InvoiceRow {
    id: number;
    invoiceNumber: string;
    status: string;
    issueDate?: string | null;
    dueDate?: string | null;
    total: number;
    client?: Client | null;
}

interface Props {
    invoices: InvoiceRow[];
    formatCurrency: (value: number) => string;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    edit: [invoiceId: number];
    delete: [invoiceId: number];
}>();

const search = ref('');
const statusFilter = ref('all');
const clientFilter = ref('all');
const sorting = ref<SortingState>([]);

const clientOptions = computed(() => {
    const map = new Map<number, string>();
    props.invoices.forEach((invoice) => {
        if (invoice.client?.id && invoice.client?.name) {
            map.set(invoice.client.id, invoice.client.name);
        }
    });

    return Array.from(map.entries()).map(([id, name]) => ({ id, name }));
});

const filteredData = computed(() => {
    const query = search.value.trim().toLowerCase();

    return props.invoices.filter((invoice) => {
        if (statusFilter.value !== 'all' && invoice.status !== statusFilter.value) {
            return false;
        }

        if (clientFilter.value !== 'all') {
            if (!invoice.client || String(invoice.client.id) !== clientFilter.value) {
                return false;
            }
        }

        if (!query) return true;

        const haystack = [
            invoice.invoiceNumber,
            invoice.status,
            invoice.issueDate,
            invoice.dueDate,
            invoice.client?.name,
            invoice.client?.email,
        ]
            .filter(Boolean)
            .join(' ')
            .toLowerCase();

        return haystack.includes(query);
    });
});

const columnHelper = createColumnHelper<InvoiceRow>();

const columns = [
    columnHelper.accessor('invoiceNumber', {
        header: () => 'Invoice',
        cell: ({ row }) => (
            <div class= "space-y-2" >
            <Link href={`/invoices/${row.original.id}`} class="font-medium hover:text-black/70 transition" >
                { row.original.invoiceNumber }
                </Link>
                < StatusPill status = { row.original.status } />
                    </div>
        ),
    }),
columnHelper.accessor('client', {
    header: () => 'Client',
    cell: ({ row }) => (
        <div>
        <p class= "font-medium" >
        { row.original.client?.name ?? 'Unknown' }
        </p>
        < p class= "text-xs text-black/50" > { row.original.client?.email ?? '—' } </p>
            </div>
        ),
    }),
columnHelper.accessor('issueDate', {
    header: () => 'Issue date',
    cell: ({ row }) => row.original.issueDate ?? '—',
}),
    columnHelper.accessor('dueDate', {
        header: () => 'Due date',
        cell: ({ row }) => row.original.dueDate ?? '—',
    }),
    columnHelper.accessor('total', {
        header: () => 'Total',
        cell: ({ row }) => (
            <span class= "font-semibold" > { props.formatCurrency(row.original.total) } </span>
        ),
    }),
columnHelper.display({
    id: 'actions',
    header: () => <span class="text-right"> Action </span>,
        cell: ({ row }) => (
        <div class= "flex items-center justify-end gap-3" >
        <button
                    onClick={() => emit('edit', row.original.id)}
    class= "text-xs font-semibold text-black/60 hover:text-black transition"
    >
    Edit
    </button>
    < button
                    onClick = {() => emit('delete', row.original.id)}
    class= "text-xs font-semibold text-red-500/80 hover:text-red-600 transition"
    >
    Delete
    </button>
    </div>
),
    }),
];

const table = useVueTable({
    get data() {
        return filteredData.value;
    },
    columns,
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    state: {
        get sorting() {
            return sorting.value;
        },
    },
    onSortingChange: (updater) => {
        sorting.value = typeof updater === 'function' ? updater(sorting.value) : updater;
    },
});
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white">
        <div class="flex flex-wrap items-center gap-3 border-b border-black/10 px-6 py-4">
            <Input v-model="search" class="h-9 w-full max-w-xs" placeholder="Search invoices..." />
            <select v-model="statusFilter" class="h-9 rounded-md border border-black/10 bg-white px-3 text-sm">
                <option value="all">All status</option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="overdue">Overdue</option>
                <option value="paid">Paid</option>
            </select>
            <select v-model="clientFilter" class="h-9 rounded-md border border-black/10 bg-white px-3 text-sm">
                <option value="all">All clients</option>
                <option v-for="client in clientOptions" :key="client.id" :value="String(client.id)">
                    {{ client.name }}
                </option>
            </select>
            <span class="text-sm text-black/50">{{ filteredData.length }} result(s)</span>
        </div>

        <Table>
            <TableHeader>
                <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                    <TableHead v-for="header in headerGroup.headers" :key="header.id"
                        :class="header.id === 'actions' ? 'text-right' : ''">
                        <div v-if="!header.isPlaceholder" class="flex items-center gap-2">
                            <button v-if="header.column.getCanSort()" type="button"
                                class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-black/50"
                                @click="header.column.toggleSorting()">
                                <span>
                                    <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                                </span>
                                <ArrowUpDown class="h-3 w-3" />
                            </button>
                            <span v-else class="text-xs font-semibold uppercase tracking-widest text-black/50">
                                <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                            </span>
                        </div>
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="text-sm text-black">
                    <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                        <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                    </TableCell>
                </TableRow>
                <TableRow v-if="!table.getRowModel().rows.length">
                    <TableCell :colspan="columns.length" class="py-8 text-center text-sm text-black/50">
                        No invoices match your filters.
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
