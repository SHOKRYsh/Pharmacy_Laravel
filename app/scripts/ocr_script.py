import easyocr
import cv2
import matplotlib.pyplot as plt

def extract_medicine_name(image_path):
    # Initialize EasyOCR reader with English language
    reader = easyocr.Reader(['en'])

    # Read image
    image = cv2.imread(image_path)

    # Perform OCR using EasyOCR
    results = reader.readtext(image)

    # Extract the medicine name with the biggest bounding box
    medicine_name = None
    max_area = 0
    largest_bbox = None

    for (bbox, text, prob) in results:
        # Calculate the area of the bounding box
        (top_left, top_right, bottom_right, bottom_left) = bbox
        width = top_right[0] - top_left[0]
        height = bottom_left[1] - top_left[1]
        area = width * height

        # Find the largest bounding box
        if area > max_area:
            max_area = area
            medicine_name = text
            largest_bbox = bbox

    return medicine_name, largest_bbox, results

if __name__ == "__main__":
    import sys
    image_path = sys.argv[1]
    medicine_name, largest_bbox, results = extract_medicine_name(image_path)

    if medicine_name:
        print(f'Medicine name detected: {medicine_name}')
    else:
        print('No medicine name detected.')
