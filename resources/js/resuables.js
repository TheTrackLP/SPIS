export const formatDate = (dateString) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString("en-US", options);
};

export const formatTime = (timeString) => {
    const options = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
    };
    const dateObj = new Date(timeString);

    return Intl.DateTimeFormat("en-US", options).format(dateObj);
};

export const formatDateTime = (FullDateTimeString) => {
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
    };

    const dateObj = new Date(FullDateTimeString);

    if (isNaN(dateObj.getTime())) {
        return "Invalid Date";
    }

    return new Intl.DateTimeFormat("en-US", options).format(dateObj);
};

export const strHeadline = (str) => {
    return str
        .replace(/[-_]+/g, " ")
        .replace(/([a-z])([A-Z])/g, "$1 $2")
        .toLowerCase()
        .replace(/(^\w|\s\w)/g, (m) => m.toUpperCase());
};
