import notFound from "@/commons/components/errors/notFound.vue";

export const errors = [

    {
        path: "/:pathMatch(.*)*",
        name: "not-found",
        meta: {layout: notFound}
    }
];
