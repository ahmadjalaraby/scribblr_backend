export default function useImageUrl(imagePath, imageDirectory = '/storage/') {
    const baseUrl = window.location.origin + imageDirectory; // Replace with your storage base URL

    return {
        imageUrl: `${baseUrl}${imagePath}`
    };
}
