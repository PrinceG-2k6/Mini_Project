import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import os


# ================== HELPERS ==================

def get_numeric_columns(df):
    return df.select_dtypes(include=['int64', 'float64']).columns.tolist()

def get_categorical_columns(df):
    return df.select_dtypes(include=['object', 'category']).columns.tolist()

def is_valid_index_list(index_list, df):
    return all(1 <= i <= len(df.columns) for i in index_list)

def validate_columns(df, cols):
    for col in cols:
        if col not in df.columns:
            raise ValueError(f"Missing column: {col}")

def apply_theme():
    print("\nSelect Plot Theme:")
    print("1. Default")
    print("2. Dark")
    print("3. White Grid")
    print("4. Dark Grid")
    print("5. Talk")
    print("6. Poster")

    choice = input("Enter choice: ")

    theme_map = {
        '1': 'default',
        '2': 'dark_background',
        '3': 'whitegrid',
        '4': 'darkgrid',
        '5': 'talk',
        '6': 'poster'
    }

    theme = theme_map.get(choice, 'default')

    if theme == 'default':
        plt.style.use('default')
    elif theme == 'dark_background':
        plt.style.use('dark_background')
    else:
        sns.set_theme(style=theme)

    print(f"Theme applied: {theme}")


def apply_legend():
    handles, labels = plt.gca().get_legend_handles_labels()
    if labels:
        plt.legend(Title="Legend", loc="best")


def finalize_plot(Title, xlabel=None, ylabel=None):
    plt.title(Title, fontsize=14)
    if xlabel:
        plt.xlabel(xlabel)
    if ylabel:
        plt.ylabel(ylabel)
    plt.grid(True, alpha=0.3)


def ask_save_plot(default_name="plot"):
    choice = input("Do you want to save this plot? (y/n): ").lower()
    if choice == 'y':
        filename = input(f"Enter filename (default: {default_name}.png): ").strip()
        if filename == "":
            filename = f"./ML_Project/Movie_Rating/Plot/{default_name}.png"
        if not filename.endswith(".png"):
            filename = f"./ML_Project/Movie_Rating/Plot/{filename}.png"
        plt.savefig(filename, dpi=300, bbox_inches='tight')
        print(f"Plot saved as {filename}")


def get_column(df, min_c, max_c):
    while True:
        cols = df.columns.tolist()

        print("\nAvailable Columns:")
        for i, col in enumerate(cols, 1):
            print(f"{i}. {col}")

        ch = input(f"Enter column index (min {min_c}, max {max_c}) e.g.(1,2): ")

        try:
            index_list = [int(i.strip()) for i in ch.split(',')]

            if len(index_list) < min_c or len(index_list) > max_c:
                print("Invalid number of columns selected!")
                continue

            if not is_valid_index_list(index_list, df):
                print("Column index out of range!")
                continue

            return index_list

        except ValueError:
            print("Enter only numbers separated by commas!")


# ================== VISUALIZATION ==================
def dataset_summary(df):
    print("\n===== DATASET SUMMARY =====")

    # Drop rows with missing critical values
    clean_df = df.dropna(subset=['Rating', 'Genre', 'Year', 'Title'])

    if clean_df.empty:
        print("Not enough valid data to generate summary.")
        return

    total_movies = len(clean_df)
    avg_rating = clean_df['Rating'].mean()

    highest = clean_df.loc[clean_df['Rating'].idxmax()]
    lowest = clean_df.loc[clean_df['Rating'].idxmin()]

    common_genre = clean_df['Genre'].mode()[0]

    min_year = clean_df['Year'].min()
    max_year = clean_df['Year'].max()

    print(f"Total Movies       : {total_movies}")
    print(f"Average Rating     : {avg_rating:.2f}")
    print(f"Most Common Genre  : {common_genre}")
    print(f"Year Range         : {min_year} - {max_year}")

    print("\nTop Rated Movie:")
    print(f"Title  : ",highest['Title'])
    print(f"Rating : ",highest['Rating'])

    print("\nLowest Rated Movie:")
    print(f"Title  : ",lowest['Title'])
    print(f"Rating : ",lowest['Rating'])

def rating_distrubution(df):
    print(1)

def genre_analysis(df):
    print(1)

def votes_vs_rating(df):
    print(1)


def rating_trend(df):
    print(1)


def top_rated(df):
    print(1)


def coorelation_analysis(df):
    print(1)


def filter_year(df):
    print(1)

def visualize(df):

    while True:
        print("\n===== DATA VISUALIZATION MENU =====")
        print("1. Dataset Summary")
        print("2. Rating Distribution")
        print("3. Genre Analysis")
        print("4. Votes vs Rating")
        print("5. Rating Trend by Year")
        print("6. Top Rated Movies")
        print("7. Correlation Analysis")
        print("8. Filter by Year Range")
        print("9. Back")

        ch = input("Select Graph: ")

        try:
            # -------- DATASET SUMMARY --------
            if ch == '1':
                dataset_summary(df)

            # -------- RATING DISTRUBUTION --------
            elif ch == '2':
                cols = ["Rating","Year"]
                validate_columns(df,cols)
                
                apply_theme()
                sns.histplot(data=df[cols])
                finalize_plot("Rating Distrubution")
                ask_save_plot("Rating_Distrubution")
                plt.show()

            # -------- SCATTER --------
            elif ch == '3':
                idx = get_column(df, 2, 2)
                x, y = df.columns[idx[0]-1], df.columns[idx[1]-1]

                if x not in get_numeric_columns(df) or y not in get_numeric_columns(df):
                    print("Scatter plot requires two numeric columns!")
                    continue

                apply_theme()
                sns.scatterplot(x=df[x], y=df[y], label=f"{x} vs {y}")
                finalize_plot(f"{x} vs {y}", x, y)
                apply_legend()
                ask_save_plot("scatter_plot")
                plt.show()

            # -------- LINE --------
            elif ch == '4':
                idx = get_column(df, 1, 5)
                cols = [df.columns[i-1] for i in idx]
                numeric_cols = [c for c in cols if c in get_numeric_columns(df)]

                if not numeric_cols:
                    print("Line plot requires numeric columns!")
                    continue

                apply_theme()
                for col in numeric_cols:
                    plt.plot(df[col], label=col)

                finalize_plot("Line Plot", ylabel="Value")
                apply_legend()
                ask_save_plot("line_plot")
                plt.show()

            # -------- COUNT PLOT --------
            elif ch == '5':
                idx = get_column(df, 1, 1)
                col = df.columns[idx[0]-1]

                if col not in get_categorical_columns(df):
                    print("Count plot requires categorical column!")
                    continue

                apply_theme()
                sns.countplot(x=df[col])
                finalize_plot(f"Count Plot of {col}", col, "Count")
                ask_save_plot("count_plot")
                plt.show()

            # -------- BAR PLOT --------
            elif ch == '6':
                idx = get_column(df, 1, 2)

                apply_theme()
                if len(idx) == 1:
                    col = df.columns[idx[0]-1]
                    sns.countplot(x=df[col])
                    finalize_plot(f"Bar Plot of {col}", col, "Count")
                else:
                    x, y = df.columns[idx[0]-1], df.columns[idx[1]-1]
                    if y not in get_numeric_columns(df):
                        print("Bar plot requires numeric Y column!")
                        continue
                    sns.barplot(x=df[x], y=df[y])
                    finalize_plot("Bar Plot", x, y)

                ask_save_plot("bar_plot")
                plt.show()

            # -------- MISSING VALUE HEATMAP --------
            elif ch == '7':
                apply_theme()
                sns.heatmap(df.isna(), cbar=False)
                finalize_plot("Missing Value Heatmap")
                ask_save_plot("missing_heatmap")
                plt.show()

            # -------- BACK --------
            elif ch == '8':
                break

            else:
                print("Enter correct choice!")

        except Exception as e:
            print(f"⚠️ Plot failed safely: {e}")
