<template>
    <span :class="[colorClass, 'inline-flex items-center px-2.5 py-0.5 rounded-full capitalize']">
        {{ status }}
    </span>

</template>

<script>
export default {
    props: {
        status: String,
        color: String,
    },
    setup(props) {
        let color;

        if(props.color) {
            color = props.color;
        }else {
            color = props.status == 'active' ? 'green': color;
            color = props.status == 'pending' ? 'yellow': color;
            color = props.status == 'inactive' ? 'gray': color;
            color = props.status == 'draft' ? 'gray': color;
            color = props.status == 'ready' ? 'indigo': color;
            color = props.status == 'sent' ? 'red': color;
            color = props.status == 'received' ? 'primary': color;
            color = props.status == 'approved' ? 'green': color;
        }

        return {
            colorClass: `bg-${color}-100 text-${color}-800`
        }
    },
}
</script>
