<script setup>
const users = [
    {
        name: 'Soukayna Zaidi',
        email: 'soukayna@example.com',
        role: 'Stagiaire',
        status: 'Active',
    },
    {
        name: 'Yassine El Amrani',
        email: 'yassine@example.com',
        role: 'Encadrant',
        status: 'Pending',
    },
    {
        name: 'Atlas Digital',
        email: 'contact@atlas.ma',
        role: 'Entreprise',
        status: 'Active',
    },
    {
        name: 'Sara Alaoui',
        email: 'sara@example.com',
        role: 'Stagiaire',
        status: 'Blocked',
    },
]

const initials = (name) =>
    name
        .split(' ')
        .map((word) => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()

const statusClasses = (status) => {
    if (status === 'Active') {
        return 'bg-[#e8f6ee] text-[#459d69]'
    }

    if (status === 'Pending') {
        return 'bg-[#fff4df] text-[#c79030]'
    }

    if (status === 'Blocked') {
        return 'bg-[#fceaea] text-[#c95d5d]'
    }

    return 'bg-[#edf2f5] text-[#6c8290]'
}
</script>

<template>
    <!-- TABLE WRAPPER -->
    <div class="w-full overflow-x-auto">

        <table class="w-full border-collapse">

            <!-- HEADER -->
            <thead>
                <tr>
                    <th
                        class="px-[7px] py-2
                               text-left text-[9px]
                               font-semibold text-[#8798a4]"
                    >
                        User
                    </th>

                    <th
                        class="px-[7px] py-2
                               text-left text-[9px]
                               font-semibold text-[#8798a4]"
                    >
                        Role
                    </th>

                    <th
                        class="px-[7px] py-2
                               text-left text-[9px]
                               font-semibold text-[#8798a4]"
                    >
                        Status
                    </th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>
                <tr
                    v-for="user in users"
                    :key="user.email"
                    class="transition-colors hover:bg-[#fafcfd]"
                >
                    <!-- USER -->
                    <td
                        class="border-t border-[#edf1f4]
                               px-[7px] py-[10px]
                               text-[10px] text-[#415b6d]"
                    >
                        <div class="flex items-center gap-[9px]">

                            <!-- AVATAR -->
                            <div
                                class="flex h-[30px] w-[30px]
                                       shrink-0 items-center
                                       justify-center rounded-full
                                       bg-[#286d93]
                                       text-[8px] font-bold
                                       text-white"
                            >
                                {{ initials(user.name) }}
                            </div>

                            <!-- USER INFO -->
                            <div class="min-w-0">
                                <strong
                                    class="mb-0.5 block
                                           text-[10px] font-bold
                                           text-[#2c4354]"
                                >
                                    {{ user.name }}
                                </strong>

                                <span
                                    class="block text-[8px]
                                           text-[#91a0ab]"
                                >
                                    {{ user.email }}
                                </span>
                            </div>

                        </div>
                    </td>

                    <!-- ROLE -->
                    <td
                        class="border-t border-[#edf1f4]
                               px-[7px] py-[10px]
                               text-[10px] text-[#415b6d]"
                    >
                        {{ user.role }}
                    </td>

                    <!-- STATUS -->
                    <td
                        class="border-t border-[#edf1f4]
                               px-[7px] py-[10px]"
                    >
                        <span
                            class="inline-block rounded-full
                                   px-2 py-1
                                   text-[8px] font-bold"
                            :class="statusClasses(user.status)"
                        >
                            {{ user.status }}
                        </span>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
</template>
